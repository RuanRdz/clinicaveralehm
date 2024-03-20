<?php

namespace app\models\Protocols\Tests\Funcaomuscular;

use Illuminate\Database\Eloquent\SoftDeletingTrait;
use \Tratamento as Treatment;

class Data extends \Eloquent {

	protected $table   = 'test_funcaomuscular_data';
	protected $orderBy = 'testdate';

	use SoftDeletingTrait;
	protected $dates = array('deleted_at');

	protected $fillable = [
		'treatment_id', 'testdate', 'side_id',
		'param_id', 'scale_id'
	];
	public static $rules = [
		'treatment_id' => 'required|not_in:0',
		'param_id' => 'required|not_in:0',
        'scale_id' => 'required|not_in:0',
        'side_id' => 'required|not_in:0',
		'testdate' => 'required',
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
	public function scale()
	{
		return $this
			->belongsTo(Scale::class, 'scale_id', 'id')
			->orderBy('degree');
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

    public function setSideIdAttribute($value)
    {
        $this->attributes['side_id'] = empty(trim($value)) ? null : $value;
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
		$treatment = Treatment::findOrFail($post['treatment_id']);
		self::create($post);
		$treatment->setFezAvaliacao();
	}


	public static function getData(Treatment $treatment, $withPrevious = true)
	{
		$query = [
			'test_funcaomuscular_data.id',
			'test_funcaomuscular_data.treatment_id',
			'test_funcaomuscular_data.param_id',
			'test_funcaomuscular_data.scale_id',
			'test_funcaomuscular_data.side_id',
			'test_funcaomuscular_data.testdate',
			'param.muscle as param_muscle',
			'param.moviment as param_moviment',
			'param.sort as param_sort',
			'scale.degree as scale_degree',
			'scale.name as scale_name',
			'scale.description as scale_description'
		];

		if ($withPrevious) {
			return self::select($query)
				->join('test_funcaomuscular_param as param', 'test_funcaomuscular_data.param_id', '=', 'param.id')
				->join('test_funcaomuscular_scale as scale', 'test_funcaomuscular_data.scale_id', '=', 'scale.id')
				->join('tratamentos as treatment', 'test_funcaomuscular_data.treatment_id', '=', 'treatment.id')
				->where('test_funcaomuscular_data.treatment_id', '<=', $treatment->id)
				->where('treatment.paciente_id', '=', $treatment->paciente_id)
				->where('treatment.lesao_id', '=', $treatment->lesao_id)
				->where('test_funcaomuscular_data.deleted_at', '=', null)
				->orderBy('param.sort')
				->orderBy('test_funcaomuscular_data.testdate')
				->get();
		} else {
			return self::select($query)
				->join('test_funcaomuscular_param as param', 'test_funcaomuscular_data.param_id', '=', 'param.id')
				->join('test_funcaomuscular_scale as scale', 'test_funcaomuscular_data.scale_id', '=', 'scale.id')
				->where('test_funcaomuscular_data.treatment_id', '=', $treatment->id)
				->where('test_funcaomuscular_data.deleted_at', '=', null)
				->orderBy('param.sort')
				->orderBy('test_funcaomuscular_data.testdate')
				->get();
		}
	}

	public static function presentData($data)
	{
		$format = [];
		foreach ($data as $row) {
			$format
				[$row->param_muscle]
				[$row->param_moviment]
				[] = [
                    'id' => $row->id,
                    'treatment_id' => $row->treatment_id,
					'testdate' => $row->testdate,
					'scale_id' => $row->scale_id,
					'side' => self::$sides[$row->side_id],
				];
		}
		// echo '<pre>'; print_r($format); die;

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
