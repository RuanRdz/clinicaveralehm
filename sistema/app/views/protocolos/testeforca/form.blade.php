@extends('layouts.admin.template')

@section('head')
	@parent
	<title>Sistema</title>
@stop

@section('main-panel-heading')
	@parent
	<ol class="breadcrumb">
		<li>Clínica</li>
		<li><a href="{{ route('anamnese') }}">Relatório</a></li>
		<li class="active">Cadastro</li>
	</ol>
@stop

@section('content')
	<div class="row">
		<div class="col-xs-16 col-sm-16 col-md-10 col-lg-8">
			{{ Former::framework('TwitterBootstrap3') }}
			{{ Former::populate($testeforca) }}
			{{
				Former::vertical_open()
				->action($action)
				->secure()
				->rules($rules);
			}}
			<div class="panel panel-default">
				<div class="panel-heading">TESTE DE FORÇA MUSCULAR</div>
				<div class="panel-body">

					{{ Former::text('nome')->label('Movimento') }}
					{{ Former::text('descricao')->label('Músculos') }}
					{{
					Former::select('categoria')
						->options($categorias)
						->label('Grupo')
					}}
					<div class="row">
						<div class="col-xs-3 col-sm-2 col-md-2 col-lg-2">
							{{ Former::text('ordem')->label('Ordem') }}
						</div>
					</div>

				</div>
				<div class="panel-footer text-right">
					{{ Former::submit('Salvar')->class('btn btn-primary') }}
					@if ($testeforca->id)
						<a class="btn btn-default confirm-destroy" href="{{ route('testeforcaDestroy', ['id' => $testeforca->id]) }}">
							<i class="fa fa-trash fa-fw"></i>
						</a>
					@endif
				</div>
			</div>
			{{ Former::close() }}
		</div>
	</div>
@stop
