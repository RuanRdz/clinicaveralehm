<?php

namespace app\models\Protocols\Tests\Funcaomuscular;

use Illuminate\Database\Eloquent\SoftDeletingTrait;

class Paramgroup extends \Eloquent {

	protected $table = 'test_funcaomuscular_paramgroup';

	use SoftDeletingTrait;
	protected $dates = array('deleted_at');

	protected $fillable = [
		'name', 'sort', 'enabled'
	];
	public static $rules = [
		'name' => 'required', 
		'sort' => 'required', 
		'enabled' => 'required'
	];


	public function params()
	{
		return $this->hasMany(Param::class, 'paramgroup_id');
	}
}
