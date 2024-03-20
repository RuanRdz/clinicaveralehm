<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateTestKapandjiScaleTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('test_kapandji_scale', function(Blueprint $table)
		{
			$table->increments('id');
			$table->integer('score');
			$table->string('name');
			$table->string('description');
			$table->boolean('enabled')->default(1);
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
		Schema::drop('test_kapandji_scale');
	}

}
