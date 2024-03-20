<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateTratamentonotificacoesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('tratamentonotificacoes', function(Blueprint $table)
		{
			$table->increments('id');
			$table->integer('tratamento_id');
			$table->text('mensagem');
			$table->enum('lido', array('N', 'Y'))->default('N');
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
		Schema::drop('tratamentonotificacoes');
	}

}
