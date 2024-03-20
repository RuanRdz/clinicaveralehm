@extends('layouts.admin.template')

@section('head')
	@parent
	<title>Sistema</title>
@stop

@section('main-panel-heading')
	@parent
	<ol class="breadcrumb">
		<li><a href="{{ route('pacientes') }}">Pacientes</a></li>
		<li><a href="{{ route('painel', ['id' => $paciente->id]) }}">{{ $paciente->nome }}</a></li>
		<li class="active">Visualizar</li>
	</ol>
@stop

@section('content')

	<div class="no-print text-right">
		<a
			href="{{ route('pacientesEdit', ['id' => $paciente->id]) }}"
			class="btn btn-default">
			<i class="fa fa-pencil fa-lg"></i> Editar Cadastro
		</a>
		<a
			href="{{ route('painel', ['id' => $paciente->id]) }}"
			class="btn btn-default">
			<i class="fa fa-stethoscope fa-lg"></i> Ir para o Painel
		</a>
        <button type="button" class="print-trigger btn btn-default">
            <i class="fa fa-print fa-lg"></i> Imprimir
        </button>
    </div>

	{{ View::make('layouts.admin.print-header') }}

	<div class="row">
		<div class="col-xs-6 col-xs-offset-5 col-sm-4 col-sm-offset-6 col-md-3 col-md-offset-6 col-lg-2 col-lg-offset-0">
			<div class="circular-crop" style="background-image: url({{ $paciente->foto }})"></div>
		</div>

		<div class="col-xs-16 col-lg-14">
			
			<div class="text-lg font-bold my-6">
                {{ $paciente->nome }}
            </div>

			<div class="row">
				<div class="col-xs-16 col-sm-16 col-md-16 col-lg-6">
					<table class="table table-hover">
						@include('pacientes.dados-pessoais')
					</table>
				</div>
				<div class="col-xs-16 col-sm-16 col-md-16 col-lg-10">
					<table class="table table-hover">
						@include('pacientes.anamnese')
					</table>
				</div>
			</div>

		</div>

	</div>

	<div class="no-print">
		@if($paciente->observacoes)
			<div style="page-break-before: always;">
				<p><strong>Observações</strong> <small>(Uso interno)</small></p>
				{{ nl2br($paciente->observacoes) }}
			</div>
		@endif
	</div>

    <div class="no-print">
		{{ View::make('layouts.admin.update-info')->with(array('user' => $paciente))->render() }}
    </div>

	{{ View::make('layouts.admin.print-footer') }}
@stop
