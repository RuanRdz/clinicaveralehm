<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateConveniosTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('convenios', function(Blueprint $table)
		{
			$table->increments('id');
			$table->string('nome');
			$table->integer('cidade_id')->nullable()->default(null);
			$table->integer('conveniotipo_id');
			$table->decimal('valor', 10, 2);
			$table->integer('dia_vencimento')->nullable()->default(null);
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
		Schema::drop('convenios');
	}

}
