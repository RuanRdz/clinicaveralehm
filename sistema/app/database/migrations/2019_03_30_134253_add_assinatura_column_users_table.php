<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddAssinaturaColumnUsersTable extends Migration {

	public function up()
	{
		Schema::table('users', function(Blueprint $table)
		{
            $table->string('assinatura')->after('email')->nullable();
		});
	}

	public function down()
	{
		Schema::table('users', function(Blueprint $table)
		{
            $table->dropColumn('assinatura');
		});
	}

}
