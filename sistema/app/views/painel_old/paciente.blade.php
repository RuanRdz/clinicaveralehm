
<div class="panel panel-default">

	<div class="panel-heading">
		<strong>{{ $paciente->nome }}</strong>
	</div>

	<div class="panel-body">

		<div class="row">
			<div class="col-xs-4">
				<div class="circular-crop" style="background-image: url({{ $paciente->foto }})"></div>
			</div>
			<div class="col-xs-11 col-xs-offset-1">
				<p>
					<a
						href="{{ route('pacientesEdit', ['id' => $paciente->id]) }}"
						class="btn btn-xs btn-default">
						<i class="fa fa-pencil"></i> Editar
					</a>
				</p>
				<p>
					<a
						href="{{ route('pacientesShow', ['id' => $paciente->id]) }}"
						class="btn btn-xs btn-default">
						<i class="fa fa-print"></i> Visualizar
					</a>
				</p>
				<p>
					<a
						href="{{ route('pacientesArquivo', ['id' => $paciente->id]) }}"
						class="btn btn-xs btn-default">
						<i class="fa fa-folder-open-o"></i> Arquivo
					</a>
				</p>
			</div>
		</div>

	</div>
	
	<div class="panel-body">

		<table 
			class="table table-sm table-bordered table-striped table-hover table-painel"
			style="margin-bottom: 15px;">
			@include('pacientes.dados-pessoais')
		</table>

		<table 
			class="table table-sm table-bordered table-striped table-hover table-painel">
			@include('pacientes.anamnese')
		</table>

	</div>

</div>