<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTestFuncaomuscularDataTable extends Migration {

	public function up()
	{
		Schema::create('test_funcaomuscular_data', function(Blueprint $table)
		{
			$table->increments('id');
			$table->integer('treatment_id')->unsigned();
			$table->integer('param_id')->unsigned();
			$table->integer('scale_id')->unsigned();
			$table->date('testdate')->nullable()->default(null);
			$table->timestamps();
			$table->softDeletes();
		});
	}

	public function down()
	{
		Schema::drop('test_funcaomuscular_data');
	}

}
