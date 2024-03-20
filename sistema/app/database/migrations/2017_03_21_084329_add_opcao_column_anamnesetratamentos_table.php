<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddOpcaoColumnAnamnesetratamentosTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('anamnesetratamentos', function($table)
		{
		    $table->integer('opcao')
		    	->after('checkbox')
				->default(0);
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('anamnesetratamentos', function($table)
		{
		    $table->dropColumn('anexar_anteriores');
		});
	}

}
