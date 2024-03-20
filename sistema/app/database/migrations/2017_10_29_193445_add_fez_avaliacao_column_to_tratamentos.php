<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddFezAvaliacaoColumnToTratamentos extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('tratamentos', function(Blueprint $table)
		{
		    $table->boolean('fez_avaliacao')
		    	->after('data_relatorio')
				->default(0);
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('tratamentos', function(Blueprint $table)
		{
			$table->dropColumn('fez_avaliacao');
		});
	}

}
