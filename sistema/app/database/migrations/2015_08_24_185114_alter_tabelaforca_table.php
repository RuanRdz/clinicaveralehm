<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterTabelaforcaTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		for($i = 1; $i <5; $i++) {
			DB::statement('ALTER TABLE `tabelaforca` CHANGE COLUMN `f'.$i.'d` `f'.$i.'d` VARCHAR(100) NULL DEFAULT NULL;');
			DB::statement('ALTER TABLE `tabelaforca` CHANGE COLUMN `f'.$i.'e` `f'.$i.'e` VARCHAR(100) NULL DEFAULT NULL;');
		}
	}

	public function down()
	{
		// Nothing to do here
	}
}
