<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTestJebsenDataTable extends Migration {

	public function up()
	{
		Schema::create('test_jebsen_data', function(Blueprint $table)
		{
			$table->increments('id');
			$table->integer('treatment_id')->unsigned();
			$table->integer('param_id')->unsigned();
			$table->time('time_left_hand');
			$table->time('time_right_hand');
			$table->date('testdate')->nullable()->default(null);
			$table->timestamps();
			$table->softDeletes();
		});
	}

	public function down()
	{
		Schema::drop('test_jebsen_data');
	}

}
