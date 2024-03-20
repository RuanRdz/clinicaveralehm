<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTestGoniometroDataTable extends Migration {

	public function up()
	{
		Schema::create('test_goniometro_data', function(Blueprint $table)
		{
			$table->increments('id');
			$table->integer('treatment_id')->unsigned();
			$table->integer('param_id')->unsigned();
			$table->integer('side_id')->unsigned();
			$table->integer('degree_active');
			$table->integer('degree_passive');
			$table->date('testdate')->nullable()->default(null);
			$table->timestamps();
			$table->softDeletes();
		});
	}

	public function down()
	{
		Schema::drop('test_goniometro_data');
	}

}
