<?php

namespace app\models\Protocols\Tests\Funcaomuscular;

use Illuminate\Database\Eloquent\SoftDeletingTrait;

class Scale extends \Eloquent {

	protected $table   = 'test_funcaomuscular_scale';
	protected $orderBy = 'degree';

	use SoftDeletingTrait;
	protected $dates = array('deleted_at');

	protected $fillable = [
		'degree', 'name', 'description', 'enabled'
	];
	public static $rules = [
		'degree' => 'required',
		'name' => 'required',
		'description' => 'required'
	];


	// Mutators

	public function setNameAttribute($value)
	{
		$this->attributes['name'] = mb_strtoupper(trim($value), 'UTF-8');
	}
	public function setDescriptionAttribute($value)
	{
		$this->attributes['description'] = mb_strtoupper(trim($value), 'UTF-8');
	}


	// Data

	public static function selectBox()
	{
		return ['' => ''] + self::lists('name', 'id');
	}
}
