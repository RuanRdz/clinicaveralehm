<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterTratamentosTable4 extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('tratamentos', function($table)
		{
		    $table->string('controle_relatorio')
		    	->after('laudo_certificado')
		    	->nullable()
		    	->default('A,B,C,D,E,F,TF,TFM,AM');
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
		    $table->dropColumn('controle_relatorio');
		});
	}

}
