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

	<h3 class="no-print text-center">
		<a class="print-trigger" href="" title="Imprimir"><i class="fa fa-print"></i></a>
		<hr />
	</h3>

	{{ View::make('layouts.admin.print-header') }}

	@include('tratamentos.atividades.index.header')

	<p class="report-title">ATIVIDADES</p>

	@if(in_array('B', $dadosControle))
		@include('tratamentos.atividades.index.realizamos')
	@endif

	@if(in_array('C', $dadosControle))
		@include('tratamentos.atividades.index.atividades')
	@endif

	@include('tratamentos.atividades.index.paciente-retorno')

	{{ View::make('layouts.admin.print-footer') }}

@stop
