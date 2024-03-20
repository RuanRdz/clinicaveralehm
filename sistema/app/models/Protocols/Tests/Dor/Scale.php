<?php

namespace app\models\Protocols\Tests\Dor;

use Illuminate\Database\Eloquent\SoftDeletingTrait;

class Scale extends \Eloquent {

	protected $table   = 'test_dor_scale';
	protected $orderBy = 'score';

	use SoftDeletingTrait;
	protected $dates = array('deleted_at');

	protected $fillable = [
		'score', 'name', 'color', 'image', 'enabled'
	];
	public static $rules = [
		'score' => 'required'
	];


	// Data

	public static function selectBox()
	{
		return ['' => ''] + self::lists('score', 'id');
	}
}
