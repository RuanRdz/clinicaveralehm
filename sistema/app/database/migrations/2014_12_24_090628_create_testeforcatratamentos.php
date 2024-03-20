<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateTesteforcatratamentos extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('testeforcatratamentos', function(Blueprint $table)
		{
			$table->increments('id');
			$table->integer('tratamento_id');
			$table->integer('testeforca_id');
			$table->date('data_sessao');
			$table->integer('grau');
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
		Schema::drop('testeforcatratamentos');
	}

}
