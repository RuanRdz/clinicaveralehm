<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddCidadeIdToFinanceiroTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('financeiro', function(Blueprint $table)
		{
			$table->integer('cidade_id')->after('tipodespesa_id')->nullable()->default(null);
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
			$table->dropColumn('cidade_id');
		});
	}

}
