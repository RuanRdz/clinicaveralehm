<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class AddCamposComplementaresToPacientesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('pacientes', function(Blueprint $table)
		{
            $table->string('orientacao_sexual')->after('sexo')->nullable();
            $table->string('naturalidade')->after('cpf')->nullable();
            $table->string('etnia')->after('naturalidade')->nullable();
            $table->string('local_nascimento')->after('nascimento')->nullable();
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('pacientes', function(Blueprint $table)
		{
            $table->dropColumn('orientacao_sexual');
            $table->dropColumn('naturalidade');
            $table->dropColumn('etnia');
            $table->dropColumn('local_nascimento');
		});
	}

}
