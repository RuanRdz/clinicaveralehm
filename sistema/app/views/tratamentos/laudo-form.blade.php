@extends('layouts.admin.template')

@section('head')
	@parent
	<title>Sistema</title>
@stop

@section('main-panel-heading')
	@parent
	<ol class="breadcrumb">
		<li>{{ link_to_route('painel', $t->paciente->nome, ['id' => $t->paciente->id, 'id2' => $t->id]) }}</li>
		<li>{{ link_to_route('tratamentosLaudo', 'Laudo', ['id' => $t->id]) }}</li>
		<li class="active">Editar</li>
	</ol>
@stop

@section('content')

	{{ Former::framework('TwitterBootstrap3') }}
	{{ Former::populate($t) }}
	{{
	Former::vertical_open()
	->action(route('tratamentosUpdateLaudo', ['id' => $t->id]))
	->secure()
	}}
	<div class="row">
		<div class="col-xs-16 col-md-12 col-md-offset-2 col-lg-10 col-lg-offset-3">
            <div class="text-xl mt-8 mb-4">
                <strong>{{ $t->paciente->nome }}</strong>
            </div>
			<div class="panel panel-default">
				<div class="panel-heading">Laudo Tratamento</div>
				<div class="panel-body">
					<label>Uso de informações autorizada pelo paciente</label>
					<div class="row">
						<div class="col-xs-4 col-sm-2 col-md-2 col-lg-2">
							{{ Former::select('laudo_certificado')->options($lc)->label(false) }}
						</div>
					</div>
					{{ Former::textarea('laudo')->class('p-6 editor_laudo')->label('Descrição do Laudo') }}
				</div>
				<div class="panel-footer">
					{{ Former::actions(Former::submit('Salvar')->class('btn btn-primary'))->class('text-right') }}
				</div>
			</div>
		</div>
	</div>
	{{ Former::close() }}
@stop
