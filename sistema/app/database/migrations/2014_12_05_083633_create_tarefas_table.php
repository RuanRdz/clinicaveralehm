<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateTarefasTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('tarefas', function(Blueprint $table)
		{
			$table->increments('id');
			$table->integer('de_user_id');
			$table->integer('para_user_id');			
			$table->text('mensagem');
			$table->enum('visualizado', array('Y', 'N'))->default('N');
			$table->enum('situacao', array('aberto', 'finalizado'))->default('aberto');
			$table->string('bg_color');
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
		Schema::drop('tarefas');
	}

}
