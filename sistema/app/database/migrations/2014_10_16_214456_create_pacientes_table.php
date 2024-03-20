<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePacientesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up(){
		
		Schema::create('pacientes', function(Blueprint $table){
			$table->increments('id');
			$table->integer('cidade_id')->unsigned();
			$table->string('nome');
			$table->string('email');
			$table->string('rg');
			$table->string('cpf');
			$table->date('nascimento')->nullable()->default(null);
			$table->enum('sexo', array('M', 'F'))->nullable()->default(null);
			$table->string('endereco');
			$table->string('fone_residencial');
			$table->string('fone_comercial');
			$table->string('fone_celular');
			$table->string('operadora_celular');
			$table->string('empresa');
			$table->string('profissao');
			$table->string('foto')->nullable()->default(null);
			$table->text('observacoes');

			$table->string('tempo_empresa');
			$table->string('tempo_afastamento');
			$table->string('num_empresas_trabalhou');
			$table->string('religiao');
			$table->string('hobby');
			$table->string('outros');
			$table->enum('gosta_trabalhar_empresa', array('S', 'N'))->nullable()->default(null);
			$table->text('gosta_trabalhar_empresa_motivo');
			$table->enum('pegou_atestado', array('S', 'N'))->nullable()->default(null);
			$table->enum('acidente_trabalho', array('S', 'N'))->nullable()->default(null);
			$table->enum('adquirir_bens', array('S', 'N'))->nullable()->default(null);
			$table->enum('fumante', array('S', 'N'))->nullable()->default(null);
			$table->enum('estado_civil', array(
		        'SOLTEIRO',
		        'CASADO', 
		        'SEPARADO',
		        'DIVORCIADO',
		        'VIUVO',
			))->nullable()->default(null);
			$table->enum('escolaridade', array(
		        'FUNDAMENTAL',
		        'MEDIO',
		        'SUPERIOR',
		        'ESPECIALIZADO',
		        'NENHUM',
			))->nullable()->default(null);	
			$table->timestamps();
			$table->softDeletes();
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down(){
		Schema::drop('pacientes');
	}

}
