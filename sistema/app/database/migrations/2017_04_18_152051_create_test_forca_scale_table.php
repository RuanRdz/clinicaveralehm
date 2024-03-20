<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateTestForcaScaleTable extends Migration {

	public function up()
	{
		Schema::create('test_forca_scale', function(Blueprint $table)
		{
			$table->increments('id');
			$table->decimal('weight', 4, 1);
			$table->string('weightsuffix');
			$table->boolean('enabled')->default(1);
			$table->timestamps();
			$table->softDeletes();
		});
	}

	public function down()
	{
		Schema::drop('test_forca_scale');
	}

}
