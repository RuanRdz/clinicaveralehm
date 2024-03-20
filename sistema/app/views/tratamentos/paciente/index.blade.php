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

	<div class="row">
		<div class="col-xs-16 col-sm-16 col-md-5 col-lg-4">
			{{ $viewListagem }}
		</div>
		<div class="col-xs-16 col-sm-16 col-md-6 col-lg-7">
			{{ $viewInformacoes }}
		</div>
		<div class="col-xs-16 col-sm-16 col-md-5 col-lg-5">
			{{ $viewAgenda }}
		</div>
	</div>

	@if (User::allowedCredentials([10], true))
		{{ $viewFaturamento }}
	@endif

	{{ $viewLogs }}

	{{ $viewProtocols }}
@stop
