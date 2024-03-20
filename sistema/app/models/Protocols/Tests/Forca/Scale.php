<?php

namespace app\models\Protocols\Tests\Forca;

use Illuminate\Database\Eloquent\SoftDeletingTrait;

class Scale extends \Eloquent {

	protected $table = 'test_forca_scale';
    protected $orderBy = 'weight';

	use SoftDeletingTrait;
	protected $dates = array('deleted_at');

	protected $fillable = [
		'weight', 'weightsuffix', 'enabled'
	];
	public static $rules = [
		'weight' => 'required',
		'weightsuffix' => 'required',
		'enabled' => 'required'
	];


	// Mutators

	public function getValueAttribute()
	{
		$weight = $this->attributes['weight'] == 0.0 ? '0' : $this->attributes['weight'];
		return $weight.' '.$this->attributes['weightsuffix'];
	}
	public function setWeightsuffixAttribute($value)
	{
		$this->attributes['weightsuffix'] = trim(ucfirst(strtolower($value)));
	}


	public static function selectBox()
	{
		$data = self::orderBy('weight')->get();
		$scale = ['' => ''];
		foreach ($data as $row) {
			$scale[$row->id] = $row->value;
		}
		return $scale;
	}
}
