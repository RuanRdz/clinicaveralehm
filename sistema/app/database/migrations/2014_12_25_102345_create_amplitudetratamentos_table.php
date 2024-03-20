<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateAmplitudetratamentosTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('amplitudetratamentos', function(Blueprint $table)
		{
			$table->increments('id');
			$table->integer('tratamento_id');
			$table->integer('amplitude_id');
			$table->enum('lado', array('-', 'direito', 'esquerdo'))->default('-');
			$table->date('data_sessao');
			$table->integer('ativo')->nullable()->default(null);
			$table->integer('passivo')->nullable()->default(null);
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
		Schema::drop('amplitudetratamentos');
	}

}
