<?php

namespace app\models\Protocols\Tests\Goniometro;

use Illuminate\Database\Eloquent\SoftDeletingTrait;

class Param extends \Eloquent {

	protected $table   = 'test_goniometro_param';
	protected $orderBy = 'sort';

	use SoftDeletingTrait;
	protected $dates = array('deleted_at');

	protected $fillable = [
		'paramgroup_id', 'name', 'reference', 'sort', 'enabled'
	];
	public static $rules = [
		'paramgroup_id' => 'required|not_in:0', 
		'name' => 'required', 
		'reference' => 'required', 
		'sort' => 'required', 
		'enabled' => 'required'
	];

	
	// Relationship

	public function group()
	{
		return $this->belongsTo(Paramgroup::class, 'paramgroup_id');
	}

	
	// Mutators

    public function setParamgroupIdAttribute($value)
    {
        $this->attributes['paramgroup_id'] = empty(trim($value)) ? null : $value;
    }

	// public function getSideIdAttribute($value)
	// {
	// 	switch ($value) {
	// 		case 1: return $sides[$value]; break;
	// 		case 2: return $sides[$value]; break;
	// 		case 3: return $sides[$value]; break;
	// 		default return '!'; break;
	// 	}
	// }

	// public function setNameAttribute($value)
	// {
	// 	$this->attributes['name'] = mb_strtoupper(trim($value), 'UTF-8');
	// }
	// public function setReferenceAttribute($value)
	// {
	// 	$this->attributes['reference'] = mb_strtoupper(trim($value), 'UTF-8');
	// }


	// Data

	public static function selectBox()
	{
		$p = 'test_goniometro_param';
		$pg = 'test_goniometro_paramgroup';
		$data = self::select(
				$p.'.id',
				$pg.'.name as group_name',
				$p.'.name',
				$p.'.reference',
				$p.'.deleted_at'
			)
			->join($pg, $p.'.paramgroup_id', '=', $pg.'.id')
			->where($p.'.deleted_at', '=', null)
			->where($pg.'.deleted_at', '=', null)
			->orderBy($pg.'.sort')
			->orderBy($p.'.sort')
			->orderBy($p.'.reference')
			->get();

		$params[''] = [''];
		foreach ($data as $row) {
			$params[$row->group_name][$row->id] = $row->name.'&nbsp;&nbsp;&nbsp;'.$row->reference.' '.$row->deleted_at;
		}
		
		return $params;
	}
}
