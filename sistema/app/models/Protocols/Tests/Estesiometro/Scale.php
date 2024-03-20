<?php

namespace app\models\Protocols\Tests\Estesiometro;

use Illuminate\Database\Eloquent\SoftDeletingTrait;

class Scale extends \Eloquent {

	protected $table   = 'test_estesiometro_scale';
  protected $orderBy = 'sort';

	use SoftDeletingTrait;
	protected $dates = array('deleted_at');

	protected $fillable = [
		'code', 'colorname', 'colorhex', 'description',
		'sort', 'enabled'
	];
	public static $rules = [
		'code' => 'required', 
		'colorname' => 'required', 
		'colorhex' => 'required', 
		'description' => 'required', 
		'sort' => 'required', 
		'enabled' => 'required'
	];


	// Mutators

	public function setCodeAttribute($value)
	{
		$this->attributes['code'] = trim($value);
	}
	public function setColornameAttribute($value)
	{
		$this->attributes['colorname'] = trim($value);
	}
	public function setColorhexAttribute($value)
	{
		$this->attributes['colorhex'] = trim($value);
	}
	public function setDescriptionAttribute($value)
	{
		$this->attributes['description'] = trim($value);
	}


		// Data

		public static function presentLegend()
		{
			return self::where('enabled', '=', 1)
				->orderBy('sort')
				->get();
		}
}
