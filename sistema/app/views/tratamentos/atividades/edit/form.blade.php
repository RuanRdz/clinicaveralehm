@extends('layouts.admin.template')

@section('head')
	@parent
	<title>Sistema</title>
@stop

@section('main-panel-heading')
	@parent
	<ol class="breadcrumb">
		<li>{{ link_to_route('painel', $t->paciente->nome, ['id' => $t->paciente->id, 'id2' => $t->id]) }}</li>
		<li class="active">Atividades</li>
	</ol>
@stop

@section('content')

<div class="panel panel-default">
	<div class="panel-heading text-center">
		<strong>ATIVIDADES</strong>
	</div>
	<div class="panel-body">
		{{ Form::open([
			'route' => 'atividadesUpdate',
			'role' => 'form',
			'class' => 'form form-inline form-anamnesetratamentos'
		])}}
		{{ Form::hidden('tratamento_id', $t->id) }}

		<div class="row">
			
			<div class="col-xs-16 col-sm-16 col-md-8 col-lg-8">
				<div class="panel panel-default">
					<div class="panel-heading">
						<strong>{{ $blocos['B'] }}</strong>
					</div>
					<div class="panel-body">
						<table class="table valign-middle">
							<tr><th style="width: 40%;"></th><th></th></tr>
							@foreach ($opcoes['B'] as $anamnese)
								@include('tratamentos.atividades.edit.b-e-f')
							@endforeach
						</table>
					</div>
				</div>
			</div>
			
			<div class="col-xs-16 col-sm-16 col-md-8 col-lg-8">
				<div class="panel panel-default">
					<div class="panel-heading">
						<strong>{{ $blocos['E'] }}</strong>
					</div>
					<div class="panel-body">
						<table class="table valign-middle">
							<tr><th style="width: 40%;"></th><th></th></tr>
							@foreach ($opcoes['E'] as $anamnese)
								@include('tratamentos.atividades.edit.b-e-f')
							@endforeach
						</table>
					</div>
				</div>

				<div class="panel panel-default">
					<div class="panel-heading">
						<strong>{{ $blocos['F'] }}</strong>
					</div>
					<div class="panel-body">
						<table class="table valign-middle">
							<tr><th style="width: 40%;"></th><th></th></tr>
							@foreach ($opcoes['F'] as $anamnese)
								@include('tratamentos.atividades.edit.b-e-f')
							@endforeach
						</table>
					</div>
				</div>
				<p class="text-center" style="margin-top: 50px">
					{{ Form::submit('Salvar', ['class' => 'btn btn-primary']) }}
				</p>
			</div>
		</div>

		{{ Form::close() }}
	</div>
</div>

@stop
