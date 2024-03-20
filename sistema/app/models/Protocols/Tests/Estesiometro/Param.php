<?php

namespace app\models\Protocols\Tests\Estesiometro;

use Illuminate\Database\Eloquent\SoftDeletingTrait;

class Param extends \Eloquent {

	protected $table   = 'test_estesiometro_param';
	protected $orderBy = 'id';

	use SoftDeletingTrait;
	protected $dates = array('deleted_at');

	protected $fillable = [
		'position', 'description'
	];
	public static $rules = [ 
		'position' => 'required', 
		'description' => 'required'
	];


	// Additional params

	public static $membermaps = [
		'lefthand'  => 'Mão Esquerda',
		'righthand' => 'Mão Direita',
		'leftfoot'  => 'Pé Esquerdo',
		'rightfoot' => 'Pé Direito',
	];


	// Mutators

	public function setPositionAttribute($value)
	{
		$this->attributes['position'] = trim($value);
	}
	public function setDescriptionAttribute($value)
	{
		$this->attributes['description'] = mb_strtoupper(trim($value), 'UTF-8');
	}
}
