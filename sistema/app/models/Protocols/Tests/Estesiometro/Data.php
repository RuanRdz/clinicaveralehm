<?php

namespace app\models\Protocols\Tests\Estesiometro;

use Illuminate\Database\Eloquent\SoftDeletingTrait;
use \Tratamento as Treatment;

class Data extends \Eloquent {

	protected $table   = 'test_estesiometro_data';
	protected $orderBy = 'testdate';

	use SoftDeletingTrait;
	protected $dates = array('deleted_at');

	protected $fillable = [
	 	'treatment_id', 'testdate', 'svg'
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

	/*
	// Data related is alocated in the SVG

	public function param()
	{
		return $this->belongsTo(Param::class, 'param_id', 'id');
	}
	public function scale()
	{
		return $this->belongsTo(Scale::class, 'scale_id', 'id');
	}
	*/



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

	// Data


	public static function storeTest($post)
	{
		$treatment = Treatment::findOrFail($post['treatment_id']);
		self::create([
			'treatment_id' => $post['treatment_id'],
			'testdate' => $post['testdate'],
			'svg' => $post['svg'],
		]);
		$treatment->setFezAvaliacao();
	}


	public static function getData(Treatment $treatment, $withPrevious = true)
	{
		$query = [
			'test_estesiometro_data.id',
			'test_estesiometro_data.treatment_id',
			'test_estesiometro_data.testdate',
			'test_estesiometro_data.svg'
		];

		if ($withPrevious) {
			return self::select($query)
				->join('tratamentos as treatment', 'test_estesiometro_data.treatment_id', '=', 'treatment.id')
				->where('treatment.paciente_id', '=', $treatment->paciente_id)
				->where('treatment.lesao_id', '=', $treatment->lesao_id)
				->where('test_estesiometro_data.treatment_id', '<=', $treatment->id)
				->where('test_estesiometro_data.deleted_at', '=', null)
				->orderBy('test_estesiometro_data.testdate')
				->get();
		} else {
			return self::select($query)
				->where('treatment_id', '=', $treatment->id)
				->where('test_estesiometro_data.deleted_at', '=', null)
				->orderBy('test_estesiometro_data.testdate')
				->get();

		}
	}

	public static function presentData($data)
	{
		return $data;
	}

}
