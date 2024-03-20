<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateTestDorDataTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('test_dor_data', function(Blueprint $table)
		{
			$table->increments('id');
			$table->integer('treatment_id')->unsigned();
			$table->integer('scale_id')->unsigned();
			$table->integer('type_id')->unsigned();
			$table->text('comment');
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
		Schema::drop('test_dor_data');
	}

}
