<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddCepColumnToPacientesTable extends Migration 
{ 
    public function up()
    {
        Schema::table('pacientes', function(Blueprint $table)
        {
            // Limite sessões por tratamento
            $table->string('cep')->nullable()->after('endereco');
        });
    }
    
    public function down()
    {
        Schema::table('pacientes', function(Blueprint $table)
        {
            $table->dropColumn('cep');
        });
    }
}
