<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class AddColorAndBackgroundColumnsToComplexidadeTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('complexidade', function(Blueprint $table)
		{
			$table
				->string('color')
				->after('nome')
				->default('#fff');

			$table
				->string('bg_color')
				->after('color')
				->default('#b5b5b5');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('complexidade', function(Blueprint $table)
		{
			$table->dropColumn('color');
			$table->dropColumn('bg_color');
		});
	}

}
