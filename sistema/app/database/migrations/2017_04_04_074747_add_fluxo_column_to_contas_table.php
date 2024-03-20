<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddFluxoColumnToContasTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('contas', function($table)
		{
		    $table->boolean('mostrar_no_fluxo')
		    	->after('conta')
				->default(1);
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('contas', function($table)
		{
		    $table->dropColumn('mostrar_no_fluxo');
		});
	}

}
