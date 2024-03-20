<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterFinanceiroTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('financeiro', function($table)
		{
		    $table->enum('previsao', array(0, 1))->default(0)->after('valor');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('financeiro', function($table)
		{
		    $table->dropColumn('previsao');
		});
	}

}
