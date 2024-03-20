<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateTratamentosituacoesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('tratamentosituacoes', function(Blueprint $table)
		{
			$table->increments('id');
			$table->string('nome');
			$table->string('bg_color')->default('#ffffff');
			$table->integer('uso_sistema')->nullable()->default(null);
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
		Schema::drop('tratamentosituacoes');
	}

}
