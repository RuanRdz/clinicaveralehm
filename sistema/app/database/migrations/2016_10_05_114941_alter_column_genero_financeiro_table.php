<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterColumnGeneroFinanceiroTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		DB::statement("ALTER TABLE financeiro CHANGE COLUMN genero genero ENUM('pagar', 'receber', 'receber-adm')");
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		DB::statement("ALTER TABLE financeiro CHANGE COLUMN genero genero ENUM('pagar', 'receber')");
	}

}
