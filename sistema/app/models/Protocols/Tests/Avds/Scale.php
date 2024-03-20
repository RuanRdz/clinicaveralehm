<?php

namespace app\models\Protocols\Tests\Avds;

use Illuminate\Database\Eloquent\SoftDeletingTrait;

class Scale extends \Eloquent {

	protected $table = 'test_avds_scale';

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

}
