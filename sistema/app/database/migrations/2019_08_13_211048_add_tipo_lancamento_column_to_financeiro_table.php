<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class AddTipoLancamentoColumnToFinanceiroTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('financeiro', function(Blueprint $table)
		{
            // individual | lote
            $table->string('tipo_lancamento')->after('genero')->nullable();
            $table->integer('lote')->after('tipo_lancamento')->nullable();
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('financeiro', function(Blueprint $table)
		{
            $table->dropColumn('tipo_lancamento');
            $table->dropColumn('lote');
		});
	}

}
