@extends('layouts.admin.template')

@section('head')
	@parent
	<title>Sistema</title>
@stop

@section('main-panel-heading')
	@parent
	<ol class="breadcrumb">
		<li>{{ link_to_route('painel', $t->paciente->nome, ['id' => $t->paciente->id, 'id2' => $t->id]) }}</li>
	</ol>
@stop

@section('content')

	{{ Former::framework('TwitterBootstrap3') }}
	{{ Former::populate($testeforcatratamento) }}
	{{ Former::populateField('testeforca', $testeforca_nome) }}
	{{
	Former::vertical_open()
	->action($action)
	->rules($rules)
	->secure();
	}}
	{{ Former::hidden('tratamento_id')->value($t->id) }}

	<div class="panel panel-default">
        <div class="panel-heading">
            TESTE DE FORÇA MUSCULAR
        </div>
        <div class="panel-body">
			<div class="row">
				<div class="col-xs-5 col-sm-3 col-md-2 col-lg-2">
					{{
					Former::text('data_sessao')
						->class('form-control datepicker')
						->label('<i class="fa fa-calendar"></i> Data')
					}}
				</div>
				<div class="col-xs-16 col-sm-16 col-md-10 col-lg-8">
					{{
					Former::text('testeforca')
						->id('testeforca')
						->label('Movimento / Músculos')
						->help('Digitar para pesquisar...')
					}}
					{{ Former::hidden('testeforca_id')->id('testeforca_id') }}
				</div>
				<div class="col-xs-3 col-sm-2 col-md-1 col-lg-1">
					{{
					Former::select('grau')
						->options($graus)
						->label('Grau')
					}}
				</div>
			</div>
		</div>
		<div class="panel-footer">
            {{ Form::submit('Salvar', ['class' => 'btn btn-primary']) }}
        </div>
	</div>

	{{ Former::close() }}

@stop
