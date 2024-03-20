@extends('layouts.admin.template')

@section('head')
	@parent
	<title>Sistema</title>
@stop

@section('main-panel-heading')
	@parent
	<ol class="breadcrumb">
		<li class="active">Relatório de Resultados</li>
	</ol>
@stop

@section('content')
	<div
			ng-controller="ResultsController"
			ng-init="init('{{htmlspecialchars(json_encode($data), ENT_QUOTES, 'UTF-8')}}')"
	>
		<div class="container">
			<div class="flex justify-around content-center items-center flex-wrap text-xl no-underline">
				<div>
					Relatório Quantitativo - Clínica
				</div>
				<div>

					<div class="dropdown">
						<button
								class="btn btn-lg btn-default dropdown-toggle"
								type="button"
								id="dropdownMenu1"
								data-toggle="dropdown"
						>
							<i class="fa fa-line-chart"></i>
							Gráficos
							<span class="caret"></span>
						</button>
						<ul class="dropdown-menu" aria-labelledby="dropdownMenu1" style="margin-top: -3px;">
							<li>
								<a href="{{ route('results', ['chart' => 'createdPatientsAnnually']) }}">Novos Pacientes - Anual</a>
							</li>
							<li>
								<a href="{{ route('results', ['chart' => 'treatmentsFinishedAnnually']) }}">Tratamentos Finalizados - Anual</a>
							</li>
							<li>
								<a href="{{ route('results', ['chart' => 'treatmentsCanceledAnnually']) }}">Tratamentos Cancelados - Anual</a>
							</li>
							<li>
								<a href="{{ route('results', ['chart' => 'appointmentsFinishedAnnually']) }}">Sessões Finalizadas - Anual</a>
							</li>
							<li>
								<a href="{{ route('results', ['chart' => 'appointmentsCanceledAnnually']) }}">Sessões Canceladas - Anual</a>
							</li>
						</ul>
					</div>
				</div>
			</div>
			<div class="w-full py-10">
				<div id="results_chart" style="width: 100%;"></div>
			</div>
		</div>
	</div>
@stop
