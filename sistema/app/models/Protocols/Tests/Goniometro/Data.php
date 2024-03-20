<?php

namespace app\models\Protocols\Tests\Goniometro;

use Illuminate\Database\Eloquent\SoftDeletingTrait;
use \Tratamento as Treatment;

class Data extends \Eloquent {

	protected $table   = 'test_goniometro_data';
	protected $orderBy = 'testdate';

	use SoftDeletingTrait;
	protected $dates = array('deleted_at');

	protected $fillable = [
		'treatment_id', 'testdate', 'param_id', 'side_id',
		'degree_active', 'degree_passive'
	];
	public static $rules = [
		'treatment_id' => 'required|not_in:0',
		'param_id' => 'required|not_in:0',
		'side_id' => 'required|not_in:0',
		'testdate' => 'required',
		'degree_active' => 'required|integer',
		'degree_passive' => 'required|integer',
	];


	public static $sides = array(
		1 => '-',
		2 => 'Direito',
		3 => 'Esquerdo',
	);


	// Relationship

	public function treatment()
	{
		return $this->belongsTo(Treatment::class, 'treatment_id', 'id');
	}
	public function param()
	{
		return $this
			->belongsTo(Param::class, 'param_id', 'id')
			->orderBy('sort');
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

    public function setSideIdAttribute($value)
    {
        $this->attributes['side_id'] = empty(trim($value)) ? null : $value;
    }

	// Data

	public static function storeTest($post)
	{
		$treatment = Treatment::findOrFail($post['treatment_id']);
		self::create($post);
		$treatment->setFezAvaliacao();
	}


	public static function getData(Treatment $treatment, $withPrevious = true)
	{
		$query = [
			'test_goniometro_data.id',
			'test_goniometro_data.treatment_id',
			'test_goniometro_data.param_id',
			'test_goniometro_data.side_id',
			'test_goniometro_data.testdate',
			'test_goniometro_data.degree_active',
			'test_goniometro_data.degree_passive',
			'group.name as group_name',
			'param.name as param_name',
			'param.reference as param_reference',
			'param.sort as param_sort',
		];

		if ($withPrevious) {
			return self::select($query)
				->join('test_goniometro_param as param', 'test_goniometro_data.param_id', '=', 'param.id')
				->join('test_goniometro_paramgroup as group', 'param.paramgroup_id', '=', 'group.id')
				->join('tratamentos as treatment', 'test_goniometro_data.treatment_id', '=', 'treatment.id')
				->where('test_goniometro_data.treatment_id', '<=', $treatment->id)
				->where('treatment.paciente_id', '=', $treatment->paciente_id)
				->where('treatment.lesao_id', '=', $treatment->lesao_id)
				->where('test_goniometro_data.deleted_at', '=', null)
				->orderBy('param.sort')
				->orderBy('test_goniometro_data.testdate')
				->get();
		} else {
			return self::select($query)
				->join('test_goniometro_param as param', 'test_goniometro_data.param_id', '=', 'param.id')
				->join('test_goniometro_paramgroup as group', 'param.paramgroup_id', '=', 'group.id')
				->where('test_goniometro_data.treatment_id', '=', $treatment->id)
				->where('test_goniometro_data.deleted_at', '=', null)
				->orderBy('param.sort')
				->orderBy('test_goniometro_data.testdate')
				->get();
		}
	}

	public static function presentData($data)
	{
		$format = [];
		foreach ($data as $row) {
			$side = self::$sides[$row->side_id];
			if ($side != '-') {
				$side = ' ('.$side.')';
			} else {
				$side = '';
			}
			$format
				[$row->group_name.$side]
				[$row->param_name.' '.$row->param_reference]
				[] = [
                    'id' => $row->id,
                    'treatment_id' => $row->treatment_id,
					'testdate' => $row->testdate,
					'degree_active' => $row->degree_active,
                    'degree_passive' => $row->degree_passive,
                    'side' => self::$sides[$row->side_id],
				];
		}

		$transform = [];
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
		return $transform;
	}
}
