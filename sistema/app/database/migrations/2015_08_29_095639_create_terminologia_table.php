<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTerminologiaTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('terminologia', function(Blueprint $table)
		{
			$table->increments('id');
			$table->integer('parent_id')->nullable()->default(null);
			$table->integer('level');
			$table->string('code');
			$table->string('label');
			$table->boolean('is_question')->default(false);
			$table->boolean('checked')->default(false);
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
		Schema::drop('terminologia');
	}

}
