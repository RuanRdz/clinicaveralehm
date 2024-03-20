<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterTratamentosTable3 extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('tratamentos', function($table)
		{
		    $table->string('lesao_tratamento')->after('lesao_id');
		    $table->string('membro_tipo')->after('membro_id');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('tratamentos', function($table)
		{
		    $table->dropColumn('lesao_tratamento');
		    $table->dropColumn('membro_tipo');
		});
	}

}
