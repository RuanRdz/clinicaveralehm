<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateFinanceiroTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('financeiro', function(Blueprint $table)
		{
			$table->increments('id');
			$table->integer('fornecedor_id')->nullable()->default(null);
			$table->integer('tratamento_id')->nullable()->default(null);
			$table->integer('documento_id')->nullable()->default(null);
			$table->integer('formapagamento_id')->nullable()->default(null);
			$table->integer('conta_id')->nullable()->default(null);
			$table->integer('centrocusto_id')->nullable()->default(null);
			$table->integer('tipodespesa_id')->nullable()->default(null);
			$table->string('codigo');
			$table->string('descricao');
			$table->string('parcela');
			$table->date('emissao')->nullable()->default(null);
			$table->date('vencimento')->nullable()->default(null);
			$table->date('pagamento')->nullable()->default(null);
			$table->decimal('valor', 10, 2);
			$table->text('observacao');
			$table->enum('genero', array('pagar', 'receber'))->nullable()->default(null);
			$table->timestamps();
			$table->softDeletes();
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('financeiro');
	}

}
