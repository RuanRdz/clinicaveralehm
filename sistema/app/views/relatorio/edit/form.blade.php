@extends('layouts.admin.template')

@section('head')
	@parent
	<title>Sistema</title>
@stop

@section('main-panel-heading')
	@parent
	<ol class="breadcrumb">
		<li>{{ link_to_route('painel', $t->paciente->nome, ['id' => $t->paciente->id, 'id2' => $t->id]) }}</li>
		<li class="active">Edição</li>
	</ol>
@stop

@section('content')

	{{
	Form::open([
		'route' => 'relatorioUpdate',
		'role' => 'form',
		'class' => 'form form-inline form-anamnesetratamentos'
	])
	}}
	{{ Form::hidden('tratamento_id', $t->id) }}

    <div class="panel panel-default">
        <div class="panel-heading text-center"><strong>EDIÇÃO RELATÓRIO (Antigo)</strong></div>
        <div class="panel-body">

			<div class="row">
			    @include('relatorio.edit.sessoes')
			    @include('relatorio.edit.configs')
			</div>

			<p class="text-right">
				{{ Form::submit('Salvar', ['class' => 'btn btn-primary']) }}
			</p>

        </div>
    </div>

	{{ Form::close() }}

@stop
