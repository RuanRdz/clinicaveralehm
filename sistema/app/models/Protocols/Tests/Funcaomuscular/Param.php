<?php

namespace app\models\Protocols\Tests\Funcaomuscular;

use Illuminate\Database\Eloquent\SoftDeletingTrait;

class Param extends \Eloquent {

	protected $table   = 'test_funcaomuscular_param';
	protected $orderBy = 'muscle';

	use SoftDeletingTrait;
	protected $dates = array('deleted_at');

	protected $fillable = [
		'paramgroup_id', 'moviment', 'muscle', 'sort', 'enabled'
	];
	public static $rules = [
		'paramgroup_id' => 'required|not_in:0', 
		'moviment' => 'required', 
		'muscle' => 'required', 
		'sort' => 'required', 
		'enabled' => 'required'
	];


	// Relationship

	public function group()
	{
		return $this->belongsTo(Paramgroup::class, 'paramgroup_id');
	}

	
	// Mutators

	public function setMovimentAttribute($value)
	{
		$this->attributes['moviment'] = mb_strtoupper(trim($value), 'UTF-8');
    }
    
	public function setMuscleAttribute($value)
	{
		$this->attributes['muscle'] = mb_strtoupper(trim($value), 'UTF-8');
	}

    public function setParamgroupIdAttribute($value)
    {
        $this->attributes['paramgroup_id'] = empty(trim($value)) ? null : $value;
    }

	// Data

	// public static function selectBox()
	// {
	// 	$data = self::get();
	// 	$params[''] = [''];
	// 	foreach ($data as $row) {
	// 		$params[$row->muscle][$row->id] = $row->moviment;
	// 	}
	// 	return $params;
	// }
}
