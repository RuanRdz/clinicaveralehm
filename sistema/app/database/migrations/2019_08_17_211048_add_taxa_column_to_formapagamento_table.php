<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class AddTaxaColumnToFormapagamentoTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('formapagamento', function(Blueprint $table)
		{
            $table->decimal('taxa', 10, 2)->after('nome')->default(0);
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('formapagamento', function(Blueprint $table)
		{
            $table->dropColumn('taxa');
		});
	}

}
