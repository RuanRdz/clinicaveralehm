<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateTerminologiaTratamentoTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('terminologia_tratamento', function(Blueprint $table)
		{
			$table->increments('id');
			$table->integer('terminologia_id')->unsigned()->index();
			$table->foreign('terminologia_id')->references('id')->on('terminologia')->onDelete('cascade');
			$table->integer('tratamento_id')->unsigned()->index();
			$table->foreign('tratamento_id')->references('id')->on('tratamentos')->onDelete('cascade');
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
		Schema::drop('terminologia_tratamento');
	}

}
