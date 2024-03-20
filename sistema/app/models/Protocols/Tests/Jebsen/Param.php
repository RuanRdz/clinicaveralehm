<?php

namespace app\models\Protocols\Tests\Jebsen;

use Illuminate\Database\Eloquent\SoftDeletingTrait;

class Param extends \Eloquent {

	protected $table   = 'test_jebsen_param';
	protected $orderBy = 'id';

	use SoftDeletingTrait;
	protected $dates = array('deleted_at');

	protected $fillable = [
		'task'
	];
	public static $rules = [ 
		'task' => 'required', 
	];


	// Additional params


	// Mutators

	public function setPositionAttribute($value)
	{
		$this->attributes['task'] = trim($value);
	}
}
