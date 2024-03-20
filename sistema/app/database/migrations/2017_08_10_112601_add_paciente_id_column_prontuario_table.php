<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class AddPacienteIdColumnProntuarioTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('prontuario', function(Blueprint $table)
		{
			$table
				->integer('paciente_id')
				->unsigned()
				->nullable()
				->after('tratamento_id');
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
			$table->dropColumn('paciente_id');
		});
	}

}
