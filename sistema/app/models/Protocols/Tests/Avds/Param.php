<?php

namespace app\models\Protocols\Tests\Avds;

use Illuminate\Database\Eloquent\SoftDeletingTrait;

class Param extends \Eloquent {

	protected $table = 'test_avds_param';

	use SoftDeletingTrait;
	protected $dates = array('deleted_at');

	protected $fillable = [
		'paramgroup_id', 'name', 'sort', 'enabled'
	];
	public static $rules = [
		'paramgroup_id' => 'required|not_in:0', 
		'name' => 'required', 
		'sort' => 'required', 
		'enabled' => 'required'
	];


	public function group()
	{
		return $this->belongsTo(Paramgroup::class, 'paramgroup_id');
    }
    
    public function setParamgroupIdAttribute($value)
    {
        $this->attributes['paramgroup_id'] = empty(trim($value)) ? null : $value;
    }
}
