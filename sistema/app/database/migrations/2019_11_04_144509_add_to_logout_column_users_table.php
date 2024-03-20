<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddToLogoutColumnUsersTable extends Migration {
    
    public function up()
    {
        Schema::table('users', function(Blueprint $table)
        {
            $table->integer('to_logout')->default(0)->after('remember_token');
        });
    }
    
    public function down()
    {
        Schema::table('users', function(Blueprint $table)
        {
            $table->dropColumn('tipo');
        });
    }
}