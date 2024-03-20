<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddTipoColumnFinanceiroTable extends Migration {
    
    public function up()
    {
        Schema::table('financeiro', function(Blueprint $table)
        {
            $table->string('tipo')->default('')->after('tipo_lancamento');
        });
    }
    
    public function down()
    {
        Schema::table('financeiro', function(Blueprint $table)
        {
            $table->dropColumn('tipo');
        });
    }
}