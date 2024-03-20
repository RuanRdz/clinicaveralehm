<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTestForcaDataTable extends Migration {

	public function up()
	{
		Schema::create('test_forca_data', function(Blueprint $table)
		{
			$table->increments('id');
			$table->integer('treatment_id')->unsigned();
			$table->string('testbundle');
			$table->integer('param_id')->unsigned();
			$table->integer('scale_id_right')->unsigned();
			$table->integer('scale_id_left')->unsigned();
			$table->date('testdate')->nullable()->default(null);
			$table->timestamps();
			$table->softDeletes();
		});
	}

	public function down()
	{
		Schema::drop('test_forca_data');
	}

}
