<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateTratamentosTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('tratamentos', function(Blueprint $table)
		{
			$table->increments('id');
			$table->integer('paciente_id');
			$table->integer('tratamentotipo_id')->nullable()->default(null);
			$table->integer('convenio_id')->nullable()->default(null);
			$table->integer('medico_id')->nullable()->default(null);
			$table->integer('lesao_id')->nullable()->default(null);
			$table->integer('membro_id')->nullable()->default(null);
			$table->date('data_lesao')->nullable()->default(null);
			$table->date('data_cirurgia')->nullable()->default(null);
			$table->integer('sessoes')->default(1);
			$table->decimal('valor_sessao', 10, 2);
			$table->decimal('total', 10, 2);
			$table->integer('tratamentosituacao_id')->default(1);
			$table->text('observacoes');
			$table->text('laudo');
			$table->enum('laudo_certificado', array('Y', 'N'))->nullable()->default('N');
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
		Schema::drop('tratamentos');
	}

}
