<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class AddSideIdColumnToTestFuncaomuscularData extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('test_funcaomuscular_data', function(Blueprint $table)
		{
            $table->integer('side_id')
                ->unsigned()
                ->nullable()
                ->default('1')
                ->after('scale_id');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('test_funcaomuscular_data', function(Blueprint $table)
		{
			$table->dropColumn('side_id');
		});
	}

}
