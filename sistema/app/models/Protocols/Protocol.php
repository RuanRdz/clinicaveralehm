<?php

namespace app\models\Protocols;

use Illuminate\Database\Eloquent\SoftDeletingTrait;

class Protocol extends \Eloquent {

	protected $table = 'protocols';

	use SoftDeletingTrait;
  protected $dates = array('deleted_at');

	protected $fillable = [
		'speciality_id', 'name', 'description', 'sort', 'enabled'
	];

	public static $rules = array(
		'name' => 'required',
		'sort' => 'integer',
		'enabled' => 'integer',
	);


	// Relationship
	public function speciality()
    {
        return $this->belongsTo(Speciality::class, 'speciality_id');
    }

	public function tests()
	{
		return $this->hasMany(Test::class);
	}


	// Mutators

    public function setSpecialityIdAttribute($value)
    {
        $this->attributes['speciality_id'] = empty(trim($value)) ? null : $value;
    }

	public function setNameAttribute($value)
	{
		$this->attributes['name'] = trim($value);
    }
    
	public function setDescriptionAttribute($value)
	{
		$this->attributes['description'] = trim($value);
	}

}
