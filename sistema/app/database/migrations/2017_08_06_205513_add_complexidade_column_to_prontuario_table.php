<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class AddComplexidadeColumnToProntuarioTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('prontuario', function ($table)
			{
			$table
				->integer('complexidade_id')
				->after('terapeuta_id')
				->unsigned()
				->default(1);
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('prontuario', function(Blueprint $table)
		{
			$table->dropColumn('complexidade_id');
		});
	}

}
