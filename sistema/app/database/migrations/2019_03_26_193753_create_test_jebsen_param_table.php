<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTestJebsenParamTable extends Migration {

	public function up()
	{
		Schema::create('test_jebsen_param', function(Blueprint $table)
		{
			$table->increments('id');
            $table->string('task');
            $table->integer('sort')->default(0);
			$table->boolean('enabled')->default(1);
			$table->timestamps();
			$table->softDeletes();
		});
	}

	public function down()
	{
		Schema::drop('test_jebsen_param');
	}

}
