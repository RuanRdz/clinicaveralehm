@extends('layouts.admin.template')

@section('head')
	@parent
	<title>Sistema</title>
@stop

@section('main-panel-heading')
	@parent
	<ol class="breadcrumb">
		<li>{{ link_to_route('painel', $paciente->nome, ['id' => $paciente->id]) }}</li>
	</ol>
@stop

@section('content')

	<div class="container">
		<div class="jumbotron">
			<h4>Este paciente não realizou tratamentos.</h4>
			<p>
				<a
					class="btn btn-primary"
					href="{{ route('tratamentosCreate', ['id' => $paciente->id]) }}">
					<i class="fa fa-plus fa-fw"></i> Cadastrar Tratamento
				</a>
			</p>
		</div>
	</div>

@stop
