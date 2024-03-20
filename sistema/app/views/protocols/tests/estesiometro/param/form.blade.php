@extends('layouts.admin.template')

@section('head')
	@parent
	<title>Sistema</title>
@stop

@section('main-panel-heading')
	@parent
    <ol class="breadcrumb">
		<li><a href="{{ route('protocols.index') }}">Protocolos</a></li>
		<li>{{ $test->name }}</li>
		<li><a href="{{ route($routePath.'.index') }}">Parâmetros</a></li>
		<li class="active">Cadastro</li>
	</ol>
@stop

@section('content')
	<div class="container">
		<form class="form" action="{{ $action }}" method="post">
			{{ Form::token() }}

			<div class="jumbotron">
				<div class="form-group">
    			<label>Posição <sup>*</sup></label>
					<input
						type="text"
						name="position"
						value="{{ $data->position }}"
						required="true"
						class="form-control">
				</div>

				<div class="form-group">
    			<label>Descrição</label>
					<input
						type="text"
						name="description"
						value="{{ $data->description }}"
						class="form-control">
				</div>
			</div>

			<p class="clearfix hidden-print">
				<button
					type="submit"
					class="btn btn-primary pull-right">
					Salvar
				</button>
			</p>
		</form>
	</div>
@stop
