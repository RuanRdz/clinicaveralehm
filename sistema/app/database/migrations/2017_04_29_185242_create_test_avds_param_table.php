<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateTestAvdsParamTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('test_avds_param', function(Blueprint $table)
		{
			$table->increments('id');
			$table->integer('paramgroup_id')->unsigned()->index();
			$table->string('name');
			$table->integer('sort')->default(0);
			$table->boolean('enabled')->default(1);
			$table->timestamps();
			$table->softDeletes();
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('test_avds_param');
	}

}
