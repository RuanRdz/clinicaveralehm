<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class AddLimiteSessoesColumnToConveniosTable extends Migration {
    public function up()
    {
        Schema::table('convenios', function(Blueprint $table)
        {
            // Limite sessões por tratamento
            $table->integer('limite_sessoes')->unsigned()->default(10)->after('dia_vencimento');
        });
    }
    
    public function down()
    {
        Schema::table('convenios', function(Blueprint $table)
        {
            $table->dropColumn('limite_sessoes');
        });
    }
}
