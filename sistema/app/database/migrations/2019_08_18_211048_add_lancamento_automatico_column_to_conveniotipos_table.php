<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class AddLancamentoAutomaticoColumnToConveniotiposTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('conveniotipos', function(Blueprint $table)
		{
            $table->integer('lancamento_automatico')->after('nome')->default(0);
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('conveniotipos', function(Blueprint $table)
		{
            $table->dropColumn('lancamento_automatico');
		});
	}

}
