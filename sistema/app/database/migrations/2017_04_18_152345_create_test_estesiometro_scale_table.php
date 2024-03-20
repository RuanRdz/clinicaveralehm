<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateTestEstesiometroScaleTable extends Migration {

	public function up()
	{
		Schema::create('test_estesiometro_scale', function(Blueprint $table)
		{
			$table->increments('id');
			$table->string('code');
			$table->string('colorname');
			$table->string('colorhex');
			$table->text('description');
			$table->integer('sort')->default(0);
			$table->boolean('enabled')->default(1);
			$table->timestamps();
			$table->softDeletes();
		});
	}

	public function down()
	{
		Schema::drop('test_estesiometro_scale');
	}

}
