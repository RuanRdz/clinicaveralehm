<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateAnamnesetratamentosTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('anamnesetratamentos', function(Blueprint $table)
		{
			$table->increments('id');
			$table->integer('tratamento_id');
			$table->integer('anamnese_id');
			$table->enum('avaliado', array('on', 'off'))->default('off');
			$table->enum('checkbox', array('on', 'off'))->default('off');
			$table
				->enum('dificuldade', array('Realiza','Realiza com dificuldade ou ajuda','Não realiza'))
				->nullable()
				->default(null);
			$table->string('resposta');
			$table->timestamps();
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('anamnesetratamentos');
	}

}
