<?php

namespace app\models\Protocols\Tests\Kapandji;

use Illuminate\Database\Eloquent\SoftDeletingTrait;

class Scale extends \Eloquent {

	protected $table   = 'test_kapandji_scale';
	protected $orderBy = 'score';

	use SoftDeletingTrait;
	protected $dates = array('deleted_at');

	protected $fillable = [
		'score', 'name', 'description', 'enabled'
	];
	public static $rules = [
		'score' => 'required',
		'name' => 'required'
	];

	// Data

	public static function selectBox()
	{
		return ['' => ''] + self::lists('score', 'id');
	}
}
