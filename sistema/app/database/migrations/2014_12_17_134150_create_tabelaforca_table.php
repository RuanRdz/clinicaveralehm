<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateTabelaforcaTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('tabelaforca', function(Blueprint $table)
		{
			$table->increments('id');
			$table->integer('tratamento_id');
			$table->date('data_sessao');
			$table->decimal('f1d', 10,2)->nullable()->default(null);
			$table->decimal('f1e', 10,2)->nullable()->default(null);
			$table->decimal('f2d', 10,2)->nullable()->default(null);
			$table->decimal('f2e', 10,2)->nullable()->default(null);
			$table->decimal('f3d', 10,2)->nullable()->default(null);
			$table->decimal('f3e', 10,2)->nullable()->default(null);
			$table->decimal('f4d', 10,2)->nullable()->default(null);
			$table->decimal('f4e', 10,2)->nullable()->default(null);
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
		Schema::drop('tabelaforca');
	}

}
