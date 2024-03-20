<?php

class ProtocolsTableSeeder extends Seeder {

	public function run()
	{
		DB::statement('SET FOREIGN_KEY_CHECKS=0;');
		app\models\Protocols\Protocol::truncate();
		DB::statement('SET FOREIGN_KEY_CHECKS=1;');

		$data = [
			[
				// id: 1
				'speciality_id' => 1,
				'name' => 'Sensibilidade',
				'description' => 'Avaliações Sensibilidade',
				'sort' => 1
			],
			[
				// id: 2
				'speciality_id' => 1,
				'name' => 'Força Muscular',
				'description' => 'Avaliações Força Muscular',
				'sort' => 2
			],
			[
				// id: 3
				'speciality_id' => 1,
				'name' => 'Amplitudes de Movimento',
				'description' => 'Avaliações Amplitudes de Movimento',
				'sort' => 3
			],
			[
				// id: 4
				'speciality_id' => 1,
				'name' => 'Avaliação Funcional',
				'description' => 'Avaliação Funcional',
				'sort' => 4
			],
			[
				// id: 5
				'speciality_id' => 1,
				'name' => 'Qualidade de Vida',
				'description' => 'Avaliações Qualidade de Vida',
				'sort' => 5
			],
			[
				// id: 6
				'speciality_id' => 1,
				'name' => 'Estética',
				'description' => 'Estética',
				'sort' => 6
			],
			[
				// id: 7
				'speciality_id' => 1,
				'name' => 'Sausa',
				'description' => 'Sausa',
				'sort' => 7
			],
			[
				// id: 8
				'speciality_id' => 1,
				'name' => 'Boston',
				'description' => 'Boston',
				'sort' => 8
			],
			[
				// id: 9
				'speciality_id' => 2,
				'name' => 'Paciente Neurológico',
				'description' => 'Avaliações Paciente Neurológico',
				'sort' => 9
			]
		];

		app\models\Protocols\Protocol::insert($values);
	}

}
