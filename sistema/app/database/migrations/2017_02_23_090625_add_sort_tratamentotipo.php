<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddSortTratamentotipo extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('tratamentotipos', function(Blueprint $table)
		{
			$table->integer('sequencia')->after('nome')->default(1);
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('tratamentotipos', function(Blueprint $table)
		{
			$table->dropColumn('sequencia');
		});
	}

}
