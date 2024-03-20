<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateAnamnesesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('anamnese', function(Blueprint $table)
		{
			$table->increments('id');
			$table->string('nome');
			$table->enum('bloco', array('A', 'B', 'C', 'D', 'E', 'F'));
			$table->enum('opcao', array('simples', 'composta'))->nullable()->default('simples');
			$table->string('opcao_atividade');
			$table->integer('ordem');
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
		Schema::drop('anamnese');
	}

}
