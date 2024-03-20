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
			{{ Former::populate($amplitude) }}
			{{
				Former::vertical_open()
				->action($action)
				->secure()
				->rules($rules);
			}}
			<div class="panel panel-default">
				<div class="panel-heading">AMPLITUDE DE MOVIMENTO</div>
				<div class="panel-body">

					{{ Former::text('nome')->label('Descrição') }}
					{{ Former::text('nome')->label('Movimento') }}
					{{ Former::text('parametro')->label('Graus de movimento') }}
					{{
					Former::select('amplitudegrupo_id')
						->options($grupos)
						->id('selectbox-amplitudegrupo')
						->label('Articulação')
					}}

				</div>
				<div class="panel-footer text-right">
					{{ Former::submit('Salvar')->class('btn btn-primary') }}
					@if ($amplitude->id)
						<a class="btn btn-default confirm-destroy" href="{{ route('amplitudesDestroy', ['id' => $amplitude->id]) }}">
							<i class="fa fa-trash fa-fw"></i>
						</a>
					@endif
				</div>
			</div>
			{{ Former::close() }}
		</div>
	</div>
@stop
