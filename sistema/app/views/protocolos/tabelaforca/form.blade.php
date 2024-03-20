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
	{{ Former::populate($tabelaforca) }}
	{{
	Former::vertical_open()
	->action($action)
	->rules($rules)
	->secure();
	}}
	{{ Former::hidden('tratamento_id')->value($t->id) }}

	<div class="panel panel-default">
        <div class="panel-heading">
            TABELA DE FORÇA
        </div>
        <div class="panel-body">
			<div class="row">
				<div class="col-xs-10 col-sm-10 col-md-3 col-lg-3">
					{{
					Former::text('data_sessao')
						->class('form-control datepicker')
						->label('<i class="fa fa-calendar"></i> Data')
					}}
				</div>
			</div>

			<div class="row">
				<div class="col-xs-16 col-sm-8 col-md-4 col-lg-4">
					Força de Preensão
					<div class="well well-sm">
						<div class="row">
							<div class="col-xs-16 col-sm-16 col-md-8 col-lg-8">
								{{ Former::text('f1d')->class('form-control')->label('Mão Direita') }}
							</div>
							<div class="col-xs-16 col-sm-16 col-md-8 col-lg-8">
								{{ Former::text('f1e')->class('form-control')->label('Mão Esquerda') }}
							</div>
						</div>
					</div>
				</div>

				<div class="col-xs-16 col-sm-8 col-md-4 col-lg-4">
					Pinça Polpa - Lateral
					<div class="well well-sm">
						<div class="row">
							<div class="col-xs-16 col-sm-16 col-md-8 col-lg-8">
								{{ Former::text('f2d')->class('form-control')->label('Mão Direita') }}
							</div>
							<div class="col-xs-16 col-sm-16 col-md-8 col-lg-8">
								{{ Former::text('f2e')->class('form-control')->label('Mão Esquerda') }}
							</div>
						</div>
					</div>
				</div>

				<div class="col-xs-16 col-sm-8 col-md-4 col-lg-4">
					Pinça trípode
					<div class="well well-sm">
						<div class="row">
							<div class="col-xs-16 col-sm-16 col-md-8 col-lg-8">
								{{ Former::text('f3d')->class('form-control')->label('Mão Direita') }}
							</div>
							<div class="col-xs-16 col-sm-16 col-md-8 col-lg-8">
								{{ Former::text('f3e')->class('form-control')->label('Mão Esquerda') }}
							</div>
						</div>
					</div>
				</div>

				<div class="col-xs-16 col-sm-8 col-md-4 col-lg-4">
					Pinça Polpa - Polpa
					<div class="well well-sm">
						<div class="row">
							<div class="col-xs-16 col-sm-16 col-md-8 col-lg-8">
								{{ Former::text('f4d')->class('form-control')->label('Mão Direita') }}
							</div>
							<div class="col-xs-16 col-sm-16 col-md-8 col-lg-8">
								{{ Former::text('f4e')->class('form-control')->label('Mão Esquerda') }}
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
		<div class="panel-footer">
            {{ Form::submit('Salvar', ['class' => 'btn btn-primary']) }}
        </div>
	</div>

	{{ Former::close() }}

@stop
