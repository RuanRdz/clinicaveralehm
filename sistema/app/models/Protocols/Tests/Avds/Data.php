<?php

namespace app\models\Protocols\Tests\Avds;

use Illuminate\Database\Eloquent\SoftDeletingTrait;
use app\models\Protocols\Tests\Avds\Paramgroup;
use app\models\Protocols\Tests\Avds\Scale;
use \Tratamento as Treatment;

class Data extends \Eloquent {

	protected $table = 'test_avds_data';

	use SoftDeletingTrait;
	protected $dates = array('deleted_at');

	protected $fillable = [
		'treatment_id', 'param_id', 'scale_id', 'testdate'
	];
	public static $rules = [
		'treatment_id' => 'required|not_in:0', 
		'testdate' => 'required'
	];


	// Relationship

	public function treatment()
	{
		return $this->belongsTo(Treatment::class, 'treatment_id', 'id');
	}
	public function param()
	{
		return $this->belongsTo(Param::class, 'param_id', 'id');
	}
	public function scale()
	{
		return $this->belongsTo(Scale::class, 'scale_id', 'id');
	}

	// Mutators

	public function getTestdateAttribute($value)
	{
		// TODO convert date using Carbon
		return timestampToBr($value);
    }
    
	public function setTestdateAttribute($value)
	{
		if ($value == '0000-00-00' || empty($value)) {
			$value = null;
		}
		// TODO convert date using Carbon
		$this->attributes['testdate'] = brDateToDatabase($value);
	}

    public function setTreatmentIdAttribute($value)
    {
        $this->attributes['treatment_id'] = empty(trim($value)) ? null : $value;
    }

    public function setParamIdAttribute($value)
    {
        $this->attributes['param_id'] = empty(trim($value)) ? null : $value;
    }

    public function setScaleIdAttribute($value)
    {
        $this->attributes['scale_id'] = empty(trim($value)) ? null : $value;
    }

	// Data

	public static function storeTest($post)
	{
		if (! isset($post['values'])) {
			return;
		}
		
		$treatment = Treatment::findOrFail($post['treatment_id']);
		foreach ($post['values'] as $param_id => $scale_id) {
			self::create([
				'treatment_id' => $post['treatment_id'],
				'testdate'     => $post['testdate'],
				'param_id' 	   => $param_id,
				'scale_id'     => $scale_id,
			]);
		}
		$treatment->setFezAvaliacao();
	}

	public static function getData(Treatment $treatment, $withPrevious = true)
	{
		$query = [
			'test_avds_paramgroup.name as group_name',
			'test_avds_param.name as param_name',
			'test_avds_data.id',
			'test_avds_data.treatment_id',
			'test_avds_data.testdate',
			'test_avds_data.param_id',
			'test_avds_data.scale_id',
		];

		if ($withPrevious) {
			return Paramgroup::select($query)
				->join('test_avds_param', 'test_avds_param.paramgroup_id', '=', 'test_avds_paramgroup.id')
				->join('test_avds_data', 'test_avds_data.param_id', '=', 'test_avds_param.id')
				->join('tratamentos as treatment', 'test_avds_data.treatment_id', '=', 'treatment.id')
				->where('treatment.paciente_id', '=', $treatment->paciente_id)
				->where('treatment.lesao_id', '=', $treatment->lesao_id)
				->where('test_avds_data.treatment_id', '<=', $treatment->id)
				->where('test_avds_data.deleted_at', '=', null)
				->orderBy('test_avds_paramgroup.sort')
				->orderBy('test_avds_param.sort')
				->orderBy('test_avds_data.testdate')
				->get();
		} else {

			return Paramgroup::select($query)
				->join('test_avds_param', 'test_avds_param.paramgroup_id', '=', 'test_avds_paramgroup.id')
				->join('test_avds_data', 'test_avds_data.param_id', '=', 'test_avds_param.id')
				->where('test_avds_data.treatment_id', '=', $treatment->id)
				->where('test_avds_data.deleted_at', '=', null)
				->orderBy('test_avds_paramgroup.sort')
				->orderBy('test_avds_param.sort')
				->orderBy('test_avds_data.testdate')
				->get();
		}
	}

	public static function presentData($data)
	{
		$format = $transform = $resultData = $countResult = $result = [];

		/* Format */
		foreach ($data as $row) {
			$format
				[$row->group_name]
				[$row->param_name]
				[] = [
					'id' => $row->id,
					'treatment_id' => $row->treatment_id,
					'testdate' => $row->testdate,
					'param_id' => $row->param_id,
					'scale_id' => $row->scale_id,
				];
			$resultData[$row->testdate][] = $row->scale_id;
		}
		// echo '<pre>'; print_r($format); die;


		/* Transform */
		// Group
		$group_index = $group_sum_params = $group_data_index = 0;
		foreach ($format as $group_name => $params) {
			$group_rowspan = 0;
			
			// Param
			$param_index = 0;
			foreach ($params as $param_name => $data) {
				$param_rowspan = 0;
				$group_sum_params++;

				// Data
				$data_index = 0;
				foreach ($data as $values) {
					$data_index++;
					$group_data_index++;
					$param_rowspan++;
					$group_rowspan++;
					$transform
						[$group_name]['params'][$param_name]
						['data'][$data_index] = array_merge(['group_data_index' => $group_data_index], $values);
				}
			
				$param_index++;
				$transform[$group_name]['params'][$param_name]['index'] = $param_index;
				$transform[$group_name]['params'][$param_name]['rowspan'] = $param_rowspan;
			}
			
			$group_index++;
			$transform[$group_name]['index'] = $group_index;
			$transform[$group_name]['rowspan'] = $group_rowspan;
			$transform[$group_name]['sum_params'] = $group_sum_params;
			$group_sum_params = $group_data_index = 0;
		}
		// echo '<pre>'; print_r($transform); die;

		/* Result */
		foreach ($resultData as $testdate => $tests) {
			$numOfItems = count($resultData[$testdate]);
			$countTests = array_count_values($tests);
			foreach ($countTests as $scale_id => $frequence) {
				$result[$testdate]['numOfItems'] = $numOfItems;
				$result[$testdate]['result'][$scale_id] = [
					'frequence' => $frequence,
					'percent' => round($frequence / $numOfItems * 100),						
				];
			}
		}
		// echo '<pre>'; print_r($result); die;
		

		return ['grid' => $transform, 'result' => $result];
	}
	
	/**
	 * Get a single previous test data by param
	 */
	public function getPrevious($treatment_id, $param_id)
	{
		$data = $this
			->where('treatment_id', '=', $treatment_id)
			->where('param_id', '=', $param_id)
			->orderBy('testdate', 'DESC')
			->first();
		
		return isset($data->id) 
			? $data->testdate.' - '.$data->scale->name 
			: '-';
	} 
}
