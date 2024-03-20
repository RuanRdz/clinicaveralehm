<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateTestFuncaomuscularScaleTable extends Migration {

	public function up()
	{
		Schema::create('test_funcaomuscular_scale', function(Blueprint $table)
		{
			$table->increments('id');
			$table->integer('degree');
			$table->string('name');
			$table->string('description');
			$table->boolean('enabled')->default(1);
			$table->timestamps();
			$table->softDeletes();
		});
	}

	public function down()
	{
		Schema::drop('test_funcaomuscular_scale');
	}

}
