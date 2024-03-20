<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterAgendasTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('agendas', function($table)
		{
		    $table
		        ->integer('terapeuta_id_bloqueio')
		        ->nullable()
		        ->default(null)
		        ->after('descricao_bloqueio');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('agendas', function($table)
		{
		    $table->dropColumn('terapeuta_id_bloqueio');
		});
	}

}
