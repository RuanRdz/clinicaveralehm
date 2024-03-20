<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateFornecedoresTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('fornecedores', function(Blueprint $table)
		{
			$table->increments('id');
			$table->string('nome');
			$table->string('razao_social');
			$table->string('cpf');
			$table->string('cnpj');
			$table->string('inscricao_estadual');
			$table->string('telefone');
			$table->string('celular');
			$table->string('operadora_celular');
			$table->string('email');
			$table->string('endereco');
			$table->integer('cidade_id')->nullable()->default(null);
			$table->timestamps();
			$table->softDeletes();
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('fornecedores');
	}

}
