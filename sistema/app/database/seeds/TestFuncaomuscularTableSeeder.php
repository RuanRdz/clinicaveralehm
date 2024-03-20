<?php

class TestFuncaomuscularTableSeeder extends Seeder {

	public function run()
	{
		DB::statement('SET FOREIGN_KEY_CHECKS=0;');
		app\models\Protocols\Tests\Funcaomuscular\Paramgroup::truncate();
		app\models\Protocols\Tests\Funcaomuscular\Param::truncate();
		app\models\Protocols\Tests\Funcaomuscular\Scale::truncate();
		DB::statement('SET FOREIGN_KEY_CHECKS=1;');
		
		// PARAMGROUP
		$data = [
			['name' => 'Extremidades Superiores', 'sort' => 1, 'enabled' => 1],
			['name' => 'Cabeça / Pescoço / Tronco', 'sort' => 2, 'enabled' => 1],
			['name' => 'Extremidades Inferiores', 'sort' => 3, 'enabled' => 1]
		];
		app\models\Protocols\Tests\Funcaomuscular\Paramgroup::insert($data);

		// PARAM 
		// Insert via sql file
		// app\models\Protocols\Tests\Funcaomuscular\Param::insert($data);

		// SCALE
		$data = [
			['degree' => 0, 'name' => '-', 'description' => 'Completa paralisia'],
			['degree' => 1, 'name' => 'I', 'description' => 'Vibração (esboço) de ação voluntária'],
			['degree' => 2, 'name' => 'II', 'description' => 'Ação voluntária suficiente para mover a articulação'],
			['degree' => 3, 'name' => 'III', 'description' => 'Ação contra a gravidade'],
			['degree' => 4, 'name' => 'IV', 'description' => 'Ação contra gravidade e resistência'],
			['degree' => 5, 'name' => 'V', 'description' => 'Força total']
		];
		app\models\Protocols\Tests\Funcaomuscular\Scale::insert($data);
	}
}
