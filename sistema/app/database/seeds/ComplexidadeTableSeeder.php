<?php

class ComplexidadeTableSeeder extends Seeder {

	public function run()
	{
		DB::statement('SET FOREIGN_KEY_CHECKS=0;');
		Complexidade::truncate();
		DB::statement('SET FOREIGN_KEY_CHECKS=1;');

		$data = [
			['grau' => 'A', 'nome' => 'Crítica'],
			['grau' => 'B', 'nome' => 'Alta'],
			['grau' => 'C', 'nome' => 'Média'],
			['grau' => 'D', 'nome' => 'Baixa'],
		];
		Complexidade::insert($data);
	}
}