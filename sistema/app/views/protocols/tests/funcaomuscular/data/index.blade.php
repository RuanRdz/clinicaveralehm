@extends('layouts.admin.template')

@section('head')
	@parent
	<title>Sistema</title>
@stop

@section('main-panel-heading')
	@parent
	<ol class="breadcrumb">
		<li>
			<a href="{{ route('painel', ['id' => $treatment->paciente->id, 'id2' => $treatment->id]) }}">{{ $treatment->paciente->nome }}</a>
		</li>
		<li class="active">{{ $test->name }}</li>
	</ol>
@stop

@section('content')

	<div class="row">
		<div class="col-xs-16 col-sm-16 col-md-14 col-lg-12 col-md-offset-1 col-lg-offset-2">
			<div class="panel panel-default">
				<div class="panel-heading">
					@include('protocols.tests.header-data')
				</div>
				<div class="panel-body" style="background: #E8F7D0;">
					@include('protocols.tests.'.$routePath.'.form-create')
				</div>
				@include('protocols.tests.'.$routePath.'.grid')
			</div>
		</div>
	</div>

@stop
