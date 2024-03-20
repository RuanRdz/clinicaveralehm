@extends('layouts.admin.template')

@section('head')
	@parent
	<title>Sistema</title>
@stop

@section('main-panel-heading')
	@parent
	<ol class="breadcrumb">
		<li>{{ link_to_route('painel', $paciente->nome, ['id' => $paciente->id]) }}</li>
		<li class="active">Prontuário</li>
	</ol>
@stop


@section('content')
	
	{{ 
		View::make('pacientes.profile-header')
			->with(array('title' => 'Prontuário', 'paciente' => $paciente))
	}}
	
	<div class="row">
		<div class="col-xs-16 col-md-12 col-md-offset-2 col-lg-10 col-lg-offset-3">
			<div class="panel panel-default">
				<div class="panel-heading">
					<h3>{{ $prontuario->dataprontuario }}</h3>
				</div>
				<div class="panel-body">
					<div class="text-justify">{{ nl2br($prontuario->descricao) }}</div>
				</div>
				<div class="panel-footer">		
					{{ View::make('layouts.admin.update-assinatura')->with(array('user' => $prontuario))->render() }}
					{{ View::make('layouts.admin.update-info')->with(array('user' => $prontuario))->render() }}
				</div>
			</div>
		</div>
	</div>


@stop
