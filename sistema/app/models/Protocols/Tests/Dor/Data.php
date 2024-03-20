<?php

namespace app\models\Protocols\Tests\Dor;

use Illuminate\Database\Eloquent\SoftDeletingTrait;
use \Tratamento as Treatment;

class Data extends \Eloquent {

	protected $table   = 'test_dor_data';
	protected $orderBy = 'testdate';

	use SoftDeletingTrait;
	protected $dates = array('deleted_at');

	protected $fillable = [
		'treatment_id', 'scale_id', 'type_id', 'comment', 'testdate'
	];
	public static $rules = [
		'treatment_id' => 'required|not_in:0',
		'scale_id' => 'required|not_in:0',
		'type_id' => 'required|not_in:0',
		'testdate' => 'required',
	];

	public static $types = [
		1 => '-',
		2 => 'Pontual',
		3 => 'Irradia',
	];

	// Relationship

	public function treatment()
	{
		return $this->belongsTo(Treatment::class, 'treatment_id', 'id');
    }
    
	public function scale()
	{
		return $this
			->belongsTo(Scale::class, 'scale_id', 'id')
			->orderBy('score');
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

    public function setScaleIdAttribute($value)
    {
        $this->attributes['scale_id'] = empty(trim($value)) ? null : $value;
    }

    public function setTypeIdAttribute($value)
    {
        $this->attributes['type_id'] = empty(trim($value)) ? null : $value;
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
			'test_dor_data.id',
			'test_dor_data.treatment_id',
			'test_dor_data.scale_id',
			'test_dor_data.type_id',
			'test_dor_data.testdate',
			'test_dor_data.comment',
			'scale.score as scale_score',
			'scale.name as scale_name',
			'scale.name as scale_image'
		];

		if ($withPrevious) {
			return self::select($query)
				->join('test_dor_scale as scale', 'test_dor_data.scale_id', '=', 'scale.id')
				->join('tratamentos as treatment', 'test_dor_data.treatment_id', '=', 'treatment.id')
				->where('test_dor_data.treatment_id', '<=', $treatment->id)
				->where('treatment.paciente_id', '=', $treatment->paciente_id)
				->where('treatment.lesao_id', '=', $treatment->lesao_id)
				->where('test_dor_data.deleted_at', '=', null)
				// ->orderBy('scale.score')
				->orderBy('test_dor_data.testdate')
				->get();
		} else {
			return self::select($query)
				->join('test_dor_param as param', 'test_dor_data.param_id', '=', 'param.id')
				->join('test_dor_scale as scale', 'test_dor_data.scale_id', '=', 'scale.id')
				->where('test_dor_data.treatment_id', '=', $treatment->id)
				->where('test_dor_data.deleted_at', '=', null)
				// ->orderBy('scale.score')
				->orderBy('test_dor_data.testdate')
				->get();
		}
	}

	public static function presentData($data)
	{
		return $data;
	}
}
