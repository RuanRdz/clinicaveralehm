<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class AddReportOptionsColumnToTratamentosTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('tratamentos', function(Blueprint $table)
		{
			$table
				->string('report_options')
				->after('fez_avaliacao')
				->nullable();
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('tratamentos', function(Blueprint $table)
		{
			$table->dropColumn('report_options');
		});
	}

}
