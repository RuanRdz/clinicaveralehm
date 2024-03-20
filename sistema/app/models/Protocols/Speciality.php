<?php

namespace app\models\Protocols;

use Illuminate\Database\Eloquent\SoftDeletingTrait;

class Speciality extends \Eloquent {

	protected $table = 'specialties';

	use SoftDeletingTrait;
    protected $dates = array('deleted_at');

	protected $fillable = [
		'name', 'description', 'sort', 'enabled'
	];

	public static $rules = array(
		'name' => 'required',
		'sort' => 'integer',
		'enabled' => 'integer',
	);


	// Relationship

	public function protocols()
	{
		return $this->hasMany(Protocol::class, 'speciality_id');
	}


	// Mutators

	public function setNameAttribute($value)
	{
		$this->attributes['name'] = trim($value);
	}
	public function setDescriptionAttribute($value)
	{
		$this->attributes['description'] = trim($value);
	}


	// Data

	public static function menu()
	{
		$specialities = self::orderBy('sort')->get();

		$menu = [];
		foreach ($specialities as $speciality) {
			if ($speciality->enabled == 0) { continue; }
			$menu[$speciality->id] = [
				'name' => $speciality->name,
				'description' => $speciality->description,
				'protocols' => []
			];
			foreach ($speciality->protocols()->orderBy('sort')->get() as $protocol) {
                if ($protocol->enabled == 0) { continue; }
				$menu
					[$speciality->id]
					['protocols']
					[$protocol->id] = [
						'name' => $protocol->name,
						'description' => $protocol->description,
						'tests' => []
					];
				foreach ($protocol->tests()->orderBy('sort')->get() as $test) {
                    // if ($test->enabled == 0) { continue; }
					$route = null;
					if ($test->enabled == 1) {
                        $controllers = $test->extractControllers();
						if (in_array('data', $controllers)) {
							$route = $test->getRoutePrefix().'.data.index';
						}
                    }
					$menu
						[$speciality->id]
						['protocols']
						[$protocol->id]
						['tests']
						[$test->id] = [
							'namespace' => $test->namespace,
							'name' => $test->name,
							'description' => $test->description,
							'route' => $route,
						];
                }
			}
		}

		return $menu;
	}
}
