<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterAgendasTableLog extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('agendas', function($table)
		{
		    $table->integer('created_by')->after('genero');
		    $table->integer('updated_by')->nullable()->default(null)->after('created_by');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('agendas', function($table)
		{
		    $table->dropColumn('created_by');
		    $table->dropColumn('updated_by');
		});
	}

}
