<?php

class TestAvdsTableSeeder extends Seeder {

	public function run()
	{
		DB::statement('SET FOREIGN_KEY_CHECKS=0;');
		app\models\Protocols\Tests\Avds\Paramgroup::truncate();
		app\models\Protocols\Tests\Avds\Param::truncate();
		app\models\Protocols\Tests\Avds\Scale::truncate();
		DB::statement('SET FOREIGN_KEY_CHECKS=1;');

		// PARAMGROUPS
		$data = [
			['name' => 'Alimentação', 'sort' => 1],
			['name' => 'Comunicação', 'sort' => 2],
			['name' => 'Equipamentos', 'sort' => 3],
			['name' => 'Higiene', 'sort' => 4],
			['name' => 'Manipular Objetos', 'sort' => 5],
			['name' => 'Tarefas', 'sort' => 6],
			['name' => 'Vestuário', 'sort' => 7],
		];
		app\models\Protocols\Tests\Avds\Paramgroup::insert($data);

		// PARAMS
		$data = [
			['paramgroup_id' => 1, 'name' => 'Cortar com faca'],
			['paramgroup_id' => 1, 'name' => 'Cozinhar'],
			['paramgroup_id' => 1, 'name' => 'Usar copo'],
			['paramgroup_id' => 1, 'name' => 'Usar garfo / colher'],
			['paramgroup_id' => 2, 'name' => 'Escrever'],
			['paramgroup_id' => 2, 'name' => 'Telefonar'],
			['paramgroup_id' => 2, 'name' => 'Usar computador'],
			['paramgroup_id' => 3, 'name' => 'Bengala, muleta, cadeira de rodas'],
			['paramgroup_id' => 3, 'name' => 'Limpeza de quintal'],
			['paramgroup_id' => 3, 'name' => 'Órtese - colocar / tirar'],
			['paramgroup_id' => 4, 'name' => 'Abrir a pasta de dente'],
			['paramgroup_id' => 4, 'name' => 'Aparar as unhas'],
			['paramgroup_id' => 4, 'name' => 'Barbear / maquiar-se'],
			['paramgroup_id' => 4, 'name' => 'Escovar os dentes'],
			['paramgroup_id' => 4, 'name' => 'Pentear-se'],
			['paramgroup_id' => 4, 'name' => 'Tomar banho'],
			['paramgroup_id' => 4, 'name' => 'Usar lenço'],
			['paramgroup_id' => 4, 'name' => 'Usar papel higiênico'],
			['paramgroup_id' => 5, 'name' => 'Abrir recepientes '],
			['paramgroup_id' => 5, 'name' => 'Acender cigarro'],
			['paramgroup_id' => 5, 'name' => 'Dinheiro'],
			['paramgroup_id' => 5, 'name' => 'Interruptor'],
			['paramgroup_id' => 5, 'name' => 'Maçaneta'],
			['paramgroup_id' => 5, 'name' => 'Óculos'],
			['paramgroup_id' => 5, 'name' => 'Rádio'],
			['paramgroup_id' => 5, 'name' => 'Relógio'],
			['paramgroup_id' => 5, 'name' => 'Tesoura'],
			['paramgroup_id' => 5, 'name' => 'Torneira'],
			['paramgroup_id' => 6, 'name' => 'Andar de ônibus'],
			['paramgroup_id' => 6, 'name' => 'Dirigir automóvel'],
			['paramgroup_id' => 6, 'name' => 'Estender Roupas'],
			['paramgroup_id' => 6, 'name' => 'Fazer compras'],
			['paramgroup_id' => 6, 'name' => 'Lavar louça'],
			['paramgroup_id' => 6, 'name' => 'Lavar roupa'],
			['paramgroup_id' => 6, 'name' => 'Limpar casa'],
			['paramgroup_id' => 6, 'name' => 'Torcer Pano'],
			['paramgroup_id' => 7, 'name' => 'Abotoar / desabotoar'],
			['paramgroup_id' => 7, 'name' => 'Abrir / fechar zíper'],
			['paramgroup_id' => 7, 'name' => 'Colocar / tirar blusa, camiseta'],
			['paramgroup_id' => 7, 'name' => 'Dar laço'],
			['paramgroup_id' => 7, 'name' => 'Manipular fivela'],
			['paramgroup_id' => 7, 'name' => 'Por / tirar meia, meia-calça'],
			['paramgroup_id' => 7, 'name' => 'Por / tirar sapato'],
			['paramgroup_id' => 7, 'name' => 'Uso de alfinete'],
			['paramgroup_id' => 7, 'name' => 'Uso de velcro'],
			['paramgroup_id' => 7, 'name' => 'Vestir / despir calça']
		];

		$sort = 1;
		foreach ($data as $values) {
			$values['sort'] = $sort;
			app\models\Protocols\Tests\Avds\Param::create($values);
			$sort++;
		}
		unset($sort);

		// SCALE
		$data = [
			['name' => 'Realiza', 'sort' => 10],
			['name' => 'Realiza com dificuldade ou ajuda', 'sort' => 20],
			['name' => 'Não realiza', 'sort' => 30],
		];
		app\models\Protocols\Tests\Avds\Scale::insert($data);
	}
}
