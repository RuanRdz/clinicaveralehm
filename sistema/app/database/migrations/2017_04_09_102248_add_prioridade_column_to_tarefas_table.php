<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddPrioridadeColumnToTarefasTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('tarefas', function($table)
		{
		    $table->integer('prioridade')
		    	->after('mensagem')
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
		Schema::table('tarefas', function($table)
		{
		    $table->dropColumn('prioridade');
		});
	}

}
