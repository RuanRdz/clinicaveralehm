<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddSaldoInicialToFinanceiroTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
        Schema::table('financeiro', function(Blueprint $table)
        {
            $table->integer('saldo_inicial')->after('lote')->unsigned()->default(0);
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
            $table->dropColumn('saldo_inicial');
        });
	}

}
