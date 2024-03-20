<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTestEstesiometroDataTable extends Migration {

	public function up()
	{
		Schema::create('test_estesiometro_data', function(Blueprint $table)
		{
			$table->increments('id');
			$table->integer('treatment_id')->unsigned();
			$table->date('testdate')->nullable()->default(null);
			$table->longText('svg'); // svg image
			$table->timestamps();
			$table->softDeletes();
		});
	}

	public function down()
	{
		Schema::drop('test_estesiometro_data');
	}

}
