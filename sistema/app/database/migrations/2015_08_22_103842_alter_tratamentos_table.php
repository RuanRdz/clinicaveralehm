<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterTratamentosTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('tratamentos', function($table)
		{
		    $table->integer('workspace_id')->after('id');
		    $table->integer('terapeuta_id')->after('paciente_id');
		    $table->integer('created_by')->after('laudo_certificado');
		    $table->integer('updated_by')->nullable()->default(null)->after('created_by');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('tratamentos', function($table)
		{
		    $table->dropColumn('workspace_id');
		    $table->dropColumn('terapeuta_id');
		    $table->dropColumn('created_by');
		    $table->dropColumn('updated_by');
		});
	}

}
