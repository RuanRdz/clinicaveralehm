<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class AddAltaColumnToProntuarioTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('prontuario', function(Blueprint $table)
		{
		    $table->boolean('alta')
		    	->after('dataprontuario')
				->default(0);
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
			$table->dropColumn('alta');
		});
	}

}
