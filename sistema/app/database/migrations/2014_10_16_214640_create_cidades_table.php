<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCidadesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up(){

		Schema::create('cidades', function(Blueprint $table){
			$table->increments('id');
			$table->string('nome');
			$table->string('slug');
			$table->integer('capital')->default(0);
			$table->string('estado');
			$table->string('estado_uf');
			$table->string('pais');
			$table->timestamps();
			$table->softDeletes();
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down(){
		Schema::drop('cidades');
	}

}
