<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateProntuarioTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('prontuario', function(Blueprint $table)
		{
			$table->increments('id');
			$table->integer('tratamento_id')->unsigned()->index();
			$table->foreign('tratamento_id')->references('id')->on('tratamentos')->onDelete('cascade');
			$table->integer('terapeuta_id');
			$table->text('descricao');
			$table->date('dataprontuario');
		    $table->integer('created_by');
		    $table->integer('updated_by')->nullable()->default(null);
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
		Schema::drop('prontuario');
	}

}
