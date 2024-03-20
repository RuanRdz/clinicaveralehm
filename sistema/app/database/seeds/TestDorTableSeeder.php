<?php

class TestDorTableSeeder extends Seeder {

	public function run()
	{
		DB::statement('SET FOREIGN_KEY_CHECKS=0;');
		app\models\Protocols\Tests\Dor\Data::truncate();
		app\models\Protocols\Tests\Dor\Scale::truncate();
		DB::statement('SET FOREIGN_KEY_CHECKS=1;');

		// SCALE
		$data = [
			['score' => 0, 'name' => 'Sem dor', 'color' => '#FFFFFF', 'image' => ''],
			['score' => 1, 'name' => 'Muito leve', 'color' => '#B7FFFE', 'image' => ''],
			['score' => 2, 'name' => 'Desconfortável', 'color' => '#8FFEAF', 'image' => ''],
			['score' => 3, 'name' => 'Tolerável', 'color' => '#71FF55', 'image' => ''],
			['score' => 4, 'name' => 'Angustiante', 'color' => '#D1FF57', 'image' => ''],
			['score' => 5, 'name' => 'Muito angustiante', 'color' => '#F7F71D', 'image' => ''],
			['score' => 6, 'name' => 'Intensa', 'color' => '#F8C30F', 'image' => ''],
			['score' => 7, 'name' => 'Muito intensa', 'color' => '#FFA901', 'image' => ''],
			['score' => 8, 'name' => 'Horrível', 'color' => '#FF8E14', 'image' => ''],
			['score' => 9, 'name' => 'Excruciante', 'color' => '#FF6B01', 'image' => ''],
			['score' => 10, 'name' => 'Indescritível
', 'color' => '#F2390B', 'image' => ''],
		];
        app\models\Protocols\Tests\Dor\Scale::insert($data);
	}

}