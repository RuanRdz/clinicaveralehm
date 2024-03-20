<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddAnexarAnterioresToTratamentosTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('tratamentos', function($table)
		{
		    $table->string('anexar_anteriores')
		    	->after('controle_relatorio')
		    	->nullable()
		    	->default('TF,TFM,AM');
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
		    $table->dropColumn('anexar_anteriores');
		});
	}

}
