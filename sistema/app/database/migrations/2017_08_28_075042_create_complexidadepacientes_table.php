<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateComplexidadepacientesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('complexidadepacientes', function(Blueprint $table)
		{
			$table->increments('id');
			$table->integer('complexidade_id')->unsigned();
			$table->integer('paciente_id')->unsigned()->index();
			$table->integer('created_by');
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
		Schema::drop('complexidadepacientes');
	}

}
