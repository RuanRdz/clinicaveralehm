<?php

class TestsTableSeeder extends Seeder {

	public function run()
	{
		DB::statement('SET FOREIGN_KEY_CHECKS=0;');
		app\models\Protocols\Test::truncate();
		DB::statement('SET FOREIGN_KEY_CHECKS=1;');

		$data = [

			// Protocol # 1
			[
				'protocol_id' => 1,
				'namespace' => 'Estesiometro',
				'controllers' => 'Param,Scale,Data',
				'name' => 'Monofilamentos',
				'description' => 'Avaliação Monofilamentos (Estesiômetro Sorri)',
				'sort' => 1,
				'enabled' => 1
			],
			[
				'protocol_id' => 1,
				'namespace' => 'D2p',
				'controllers' => '',
				'name' => 'Discriminador de Dois Pontos',
				'description' => 'Avaliação D2P (Estático e Móvel)',
				'sort' => 2,
				'enabled' => 1
			],
			[
				'protocol_id' => 1,
				'namespace' => 'Diapazao',
				'controllers' => '',
				'name' => 'Diapazão',
				'description' => 'Teste Vibratório Diapazão (30Hz e 250Hz)',
				'sort' => 3,
				'enabled' => 1
			],
			[
				'protocol_id' => 1,
				'namespace' => 'Pickup',
				'controllers' => '',
				'name' => 'Pick-up Moberg',
				'description' => 'Avaliação Pick-up Moberg',
				'sort' => 4,
				'enabled' => 1
			],

			// Protocol # 2
			[
				'protocol_id' => 2,
				'namespace' => 'Forca',
				'controllers' => 'Param,Scale,Data',
				'name' => 'Tabela de Força',
				'description' => 'Avaliação Tabela de Força (Jamar a Pinch Gauge)',
				'sort' => 5,
				'enabled' => 1
			],
			[
				'protocol_id' => 2,
				'namespace' => 'Funcaomuscular',
				'controllers' => '',
				'name' => 'Função Muscular',
				'description' => 'Prova de Função Muscular (MRC 0-5)',
				'sort' => 6,
				'enabled' => 1
			],

			// Protocol # 3
			[
				'protocol_id' => 3,
				'namespace' => 'Goniometro',
				'controllers' => '',
				'name' => 'Goniômetro',
				'description' => 'Avaliação Goniometria',
				'sort' => 7,
				'enabled' => 1
			],

			// Protocol # 4
			[
				'protocol_id' => 4,
				'namespace' => 'Avds',
				'controllers' => 'Paramgroup,Param,Scale,Data',
				'name' => 'AVD\'s',
				'description' => 'Escala de AVD\'s',
				'sort' => 7,
				'enabled' => 1
			],
			[
				'protocol_id' => 4,
				'namespace' => 'Jebsen',
				'controllers' => '',
				'name' => 'Jebsen Taylor',
				'description' => 'Avaliação Jebsen Taylor',
				'sort' => 8,
				'enabled' => 1
			],
			[
				'protocol_id' => 4,
				'namespace' => 'Oconnor',
				'controllers' => '',
				'name' => 'O\'Connor',
				'description' => 'Avaliação O\'Connor',
				'sort' => 9,
				'enabled' => 1
			],
			[
				'protocol_id' => 4,
				'namespace' => 'Copm',
				'controllers' => '',
				'name' => 'COPM',
				'description' => 'Avaliação COPM (Medida Canadense)',
				'sort' => 10,
				'enabled' => 1
			],
			[
				'protocol_id' => 4,
				'namespace' => 'Mif',
				'controllers' => '',
				'name' => 'MIF',
				'description' => 'Avaliação MIF',
				'sort' => 11,
				'enabled' => 1
			],

			// Protocol # 5
			[
				'protocol_id' => 5,
				'namespace' => 'Sf36',
				'controllers' => '',
				'name' => 'SF36',
				'description' => 'Avaliação SF36',
				'sort' => 14,
				'enabled' => 1
			],
			[
				'protocol_id' => 5,
				'namespace' => 'Dash',
				'controllers' => '',
				'name' => 'DASH',
				'description' => 'Avaliação DASH',
				'sort' => 15,
				'enabled' => 1
			],
			[
				'protocol_id' => 5,
				'namespace' => 'Haq',
				'controllers' => '',
				'name' => 'HAQ',
				'description' => 'Avaliação HAQ',
				'sort' => 16,
				'enabled' => 1
			],

			// Protocol # 9
			[
				'protocol_id' => 9,
				'namespace' => 'Minimental',
				'controllers' => '',
				'name' => 'Mini Mental',
				'description' => 'Avaliação Mini Mental',
				'sort' => 12,
				'enabled' => 1
			],
			[
				'protocol_id' => 9,
				'namespace' => 'Rla',
				'controllers' => '',
				'name' => 'Rancho Los Amigos',
				'description' => 'Avaliação Rancho Los Amigos',
				'sort' => 13,
				'enabled' => 1
			],
		];

		// Insert
		foreach ($data as $values) {
			app\models\Protocols\Test::create($values);
		}

	}
}
