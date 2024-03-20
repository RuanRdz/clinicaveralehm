<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateTesteforca extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('testeforca', function(Blueprint $table)
		{
			$table->increments('id');
			$table->string('nome');
			$table->text('descricao');
			$table->string('categoria');			
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
		Schema::drop('testeforca');
	}

}
