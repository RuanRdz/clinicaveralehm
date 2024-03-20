<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class AddTecnicaCirurgicaColumnToTratamentosTable extends Migration {

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
				->string('tecnica_cirurgica')
				->after('data_cirurgia')
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
			$table->dropColumn('tecnica_cirurgica');
		});
	}

}
