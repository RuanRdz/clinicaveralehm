<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterPacientesTableAddFields extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('pacientes', function($table)
		{
		    $table->string('fone_recado')->after('operadora_celular');
		    $table->string('doencas_associadas')->after('outros');
		    $table->string('outros_tratamentos')->after('doencas_associadas');
		    $table->string('medicamentos')->after('outros_tratamentos');
		    $table->string('afastamento_anterior')->after('medicamentos');
		    $table->string('peso')->after('afastamento_anterior');
		    $table->string('altura')->after('peso');
		    $table->integer('created_by')->after('observacoes');
		    $table->integer('updated_by')->after('created_by')->nullable()->default(null);
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
		    $table->dropColumn('fone_recado');
		    $table->dropColumn('doencas_associadas');
		    $table->dropColumn('outros_tratamentos');
		    $table->dropColumn('medicamentos');
		    $table->dropColumn('afastamento_anterior');
		    $table->dropColumn('peso');
		    $table->dropColumn('altura');
		    $table->dropColumn('created_by');
		    $table->dropColumn('updated_by');
		});
	}

}
