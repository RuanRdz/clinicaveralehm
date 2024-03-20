<?php

// Composer: "fzaninotto/faker": "v1.3.0"
//use Faker\Factory as Faker;

class SistemaTableSeeder extends Seeder {

	public function run()
	{
		//$faker = Faker::create();
		$data = [
			['id' => 1, 'chave' => 'empresa', 'chave_label' => 'Empresa', 'descricao' => 'Company Trend Name'],
			['id' => 2, 'chave' => 'razao_social', 'chave_label' => 'Razão Social', 'descricao' => 'Company Name'],
		    ['id' => 3, 'chave' => 'crefito', 'chave_label' => 'CREFITO',	'descricao' => '99999999'],
		    ['id' => 4, 'chave' => 'endereco', 'chave_label' => 'Endereço',	'descricao' => ''],
		    ['id' => 5, 'chave' => 'cidade', 'chave_label' => 'Cidade',	'descricao' => ''],
		    ['id' => 6, 'chave' => 'telefone', 'chave_label' => 'Telefone',	'descricao' => ''],
			['id' => 7, 'chave' => 'site', 'chave_label' => 'Site', 'descricao' => 'domain.com'],
			['id' => 8, 'chave' => 'email', 'chave_label' => 'E-mail', 'descricao' => 'company@domain.com'],
			['id' => 9, 'chave' => 'facebook', 'chave_label' => 'Página Facebook',	'descricao' => '#']
		];
		
		Sistema::insert($params);
	}

}
