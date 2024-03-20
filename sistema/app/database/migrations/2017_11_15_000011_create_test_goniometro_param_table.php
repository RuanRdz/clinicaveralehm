<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTestGoniometroParamTable extends Migration {

	public function up()
	{
		Schema::create('test_goniometro_param', function(Blueprint $table)
		{
			$table->increments('id');
			$table->integer('paramgroup_id')->unsigned();
			$table->string('name');
			$table->string('reference');
			$table->integer('sort')->default(0);
			$table->boolean('enabled')->default(1);
			$table->timestamps();
			$table->softDeletes();
		});
	}

	public function down()
	{
		Schema::drop('test_goniometro_param');
	}

}
