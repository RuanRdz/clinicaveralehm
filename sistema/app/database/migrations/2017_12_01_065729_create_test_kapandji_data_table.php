<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateTestKapandjiDataTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('test_kapandji_data', function(Blueprint $table)
		{
			$table->increments('id');
			$table->integer('treatment_id')->unsigned();
			$table->integer('scale_id')->unsigned();
			$table->integer('side_id')->unsigned();
			$table->date('testdate')->nullable()->default(null);
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
		Schema::drop('test_kapandji_data');
	}

}
