<?php

class TestKapandjiTableSeeder extends Seeder {

	public function run()
	{
		DB::statement('SET FOREIGN_KEY_CHECKS=0;');
		app\models\Protocols\Tests\Kapandji\Data::truncate();
		app\models\Protocols\Tests\Kapandji\Scale::truncate();
		DB::statement('SET FOREIGN_KEY_CHECKS=1;');

		// SCALE
		$data = [
			['score' => 0, 'name' => 'Face lateral da falange proximal do 2° dedo'],
			['score' => 1, 'name' => 'Face lateral da falange média do 2° dedo'],
			['score' => 2, 'name' => 'Face lateral da falange distal do 2° dedo'],
			['score' => 3, 'name' => 'Polpa digital do 2° dedo'],
			['score' => 4, 'name' => 'Polpa digital do 3° dedo'],
			['score' => 5, 'name' => 'Polpa digital do 4° dedo'],
			['score' => 6, 'name' => 'Polpa digital do 5° dedo'],
			['score' => 7, 'name' => 'Face volar ao nível da IFD do 5° dedo'],
			['score' => 8, 'name' => 'Face volar ao nível da IFP do 5° dedo'],
			['score' => 9, 'name' => 'Prega proximal do 5° dedo'],
			['score' => 10, 'name' => 'Prega palmar distal na região ulnar'],
		];
        app\models\Protocols\Tests\Kapandji\Scale::insert($data);
	}

}