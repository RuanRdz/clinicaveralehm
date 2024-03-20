<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterPacientesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		DB::statement("ALTER TABLE `pacientes` CHANGE `gosta_trabalhar_empresa_motivo` `aspectos_positivos_empresa` TEXT");
		Schema::table('pacientes', function($table)
		{
		    $table->text('aspectos_negativos_empresa')->after('aspectos_positivos_empresa');
			$table->string('trabalhos_extras')->nullable()->after('aspectos_negativos_empresa');
			$table->string('acidente_transito')->nullable()->after('acidente_trabalho');
			$table->string('utiliza_motocicleta')->nullable()->after('acidente_transito');
		    $table->string('atividade_esportiva')->nullable()->after('hobby');
		    $table->string('lesao_anterior')->nullable()->after('reabilitacao_anterior');
		    $table->string('alergia')->nullable()->after('medicamentos');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		DB::statement("ALTER TABLE `pacientes` CHANGE `aspectos_positivos_empresa` `gosta_trabalhar_empresa_motivo` TEXT");
		Schema::table('pacientes', function($table)
		{
		    $table->dropColumn('aspectos_negativos_empresa');
		    $table->dropColumn('trabalhos_extras');
		    $table->dropColumn('acidente_transito');
		    $table->dropColumn('utiliza_motocicleta');
		    $table->dropColumn('atividade_esportiva');
		    $table->dropColumn('lesao_anterior');
		    $table->dropColumn('alergia');
		});
	}

}
