<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSaldoTable extends Migration
{
    public function up()
    {
        Schema::create('saldo', function(Blueprint $table)
        {
            $table->increments('id');
            $table->integer('conta_id')->unsigned();
            $table->date('periodo')->comment('Y-m-01');
            $table->decimal('saldo', 10, 2)->comment('Saldo em Contas = Saldo Inicial das contas + (Receitas Efetivadas - Despesas Efetivadas)');
            $table->decimal('previsao', 10, 2)->comment('Saldo Atual + (Receitas Pendentes - Despesas Pendentes)');
            $table->timestamps();
        });
    }
    
	public function down()
	{
        Schema::drop('saldo');
	}
}
