<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddNotaFiscalDataConciliacaoColumnsToFinanceiroTable extends Migration {

    public function up()
    {
        Schema::table('financeiro', function(Blueprint $table)
        {
            $table->string('nota_fiscal')->after('codigo');
            $table->decimal('desconto_taxa', 10, 2)->after('pagamento');
            $table->decimal('juros_multa', 10, 2)->after('desconto_taxa');
            $table->decimal('valor_pago', 10, 2)->after('valor');
            $table->date('data_conciliacao')->nullable()->after('saldo_inicial');
            $table->dropColumn('previsao');
        });
    }
    
    public function down()
    {
        Schema::table('financeiro', function(Blueprint $table)
        {
            $table->integer('previsao')->after('valor')->default(0);
            $table->dropColumn('nota_fiscal');
            $table->dropColumn('desconto_taxa');
            $table->dropColumn('juros_multa');
            $table->dropColumn('valor_pago');
            $table->dropColumn('data_conciliacao');
        });
    }
}
