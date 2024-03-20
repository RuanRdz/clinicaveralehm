<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterPacientesTableReabilitacao extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('pacientes', function($table)
		{
		    $table->string('reabilitacao_anterior')->after('acidente_trabalho');
		    $table->string('numero_sessoes')->after('reabilitacao_anterior');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('pacientes', function($table)
		{
		    $table->dropColumn('reabilitacao_anterior');
		    $table->dropColumn('numero_sessoes');
		});
	}

}
