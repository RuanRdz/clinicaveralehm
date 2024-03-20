<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTestEstesiometroParamTable extends Migration {

	public function up()
	{
		Schema::create('test_estesiometro_param', function(Blueprint $table)
		{
			$table->increments('id');
			$table->string('position');
			$table->string('description');
			$table->timestamps();
			$table->softDeletes();
		});
	}

	public function down()
	{
		Schema::drop('test_estesiometro_param');
	}

}
