<?php

class SpecialitiesTableSeeder extends Seeder {

	public function run()
	{
		DB::statement('SET FOREIGN_KEY_CHECKS=0;');
		app\models\Protocols\Speciality::truncate();
		DB::statement('SET FOREIGN_KEY_CHECKS=1;');

		$data = [
			['name' => 'Terapia Ocupacional', 'description' => '', 'sort' => 1],
			['name' => 'Fisioterapia', 'description' => '', 'sort' => 2],
		];

		app\models\Protocols\Speciality::insert($values);
	}

}
