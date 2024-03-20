<?php

namespace app\models\Protocols\Tests\Forca;

use Illuminate\Database\Eloquent\SoftDeletingTrait;

class Param extends \Eloquent {

	protected $table = 'test_forca_param';
    protected $orderBy = 'sort';

	use SoftDeletingTrait;
	protected $dates = array('deleted_at');

	protected $fillable = [
		'name', 'description', 'sort', 'enabled'
	];
	public static $rules = [
		'name' => 'required', 
		'sort' => 'required', 
		'enabled' => 'required'
	];


	// Additional params

	public static $hands = [
		'right' => 'Direita',
		'left'  => 'Esquerda',
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

}
