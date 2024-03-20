<?php

class TestEstesiometroTableSeeder extends Seeder {

	public function run()
	{
		DB::statement('SET FOREIGN_KEY_CHECKS=0;');
		app\models\Protocols\Tests\Estesiometro\Param::truncate();
		app\models\Protocols\Tests\Estesiometro\Scale::truncate();
		DB::statement('SET FOREIGN_KEY_CHECKS=1;');

		// PARAMS
		// Hands (50 boxes for each hand)
		for ($i=1; $i < 51; $i++) {
			app\models\Protocols\Tests\Estesiometro\Param::create([
				'position' => $i,
				'description' => ''
			]);
		}

		// SCALE
		$data = [
			[
				'code' => '1',
				'colorname' => 'Verde',
				'colorhex' => '#339933',
				'description' => 'Sensibilidade dentro da faixa considerada normal para mão e pé.',
				'sort' => 1
			],
			[
				'code' => '2',
				'colorname' => 'Azul',
				'colorhex' => '#0099ff',
				'description' => 'Sensibilidade diminuída na mão, com dificuldade quanto a discriminação fina. Ainda dentro do "normal" para o pé.',
				'sort' => 2
			],
			[
				'code' => '3',
				'colorname' => 'Violeta',
				'colorhex' => '#9900ff',
				'description' => 'Sensibilidade protetora diminuída, permanecendo o suficiente para prevenir lesões. Dificuldade com a discriminação de forma e temperatura.',
				'sort' => 3
			],
			[
				'code' => '4',
				'colorname' => 'Vermelho',
				'colorhex' => '#cc0000',
				'description' => 'Perda da sensação protetora para a mão, e às vezes, para o pé. Vulnerável a lesões. Perda da discriminação quente / frio.',
				'sort' => 4
			],
			[
				'code' => '5',
				'colorname' => 'Laranja',
				'colorhex' => '#ff6600',
				'description' => 'Perda da sensação protetora para o pé, ainda podendo sentir pressão profunda e dor.',
				'sort' => 5
			],
			[
				'code' => '6',
				'colorname' => 'Majenta',
				'colorhex' => '#ff66cc',
				'description' => 'Permanece a sensibilidade à pressão profunda e dor.',
				'sort' => 6
			],
			[
				'code' => 'x',
				'colorname' => 'Sem cor',
				'colorhex' => '#ffffff',
				'description' => 'Perda de sensibilidade à pressão profunda, normalmente não podendo sentir dor.',
				'sort' => 7
			]
		];

		app\models\Protocols\Tests\Estesiometro\Scale::insert($values);
	}

}
