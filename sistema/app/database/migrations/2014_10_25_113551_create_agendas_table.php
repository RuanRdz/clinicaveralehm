<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateAgendasTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('agendas', function(Blueprint $table)
		{
			$table->increments('id');
			$table->integer('tratamento_id')->nullable()->default(null);
			$table->integer('sessao')->default(1);
			$table->date('data_sessao')->nullable()->default(null);
			$table->time('inicio')->nullable()->default(null);
			$table->time('fim')->nullable()->default(null);
			$table->integer('agendasituacao_id')->default(1);
			$table->string('descricao_bloqueio');
			$table->enum('genero', array('atendimento', 'bloqueio'))->default('atendimento');
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
		Schema::drop('agendas');
	}

}
