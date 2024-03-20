@extends('layouts.admin.template')

@section('head')
	@parent
	<title>Sistema</title>
@stop

@section('main-panel-heading')
	@parent
	<ol class="breadcrumb">
		<li><a href="{{ route('pacientes') }}">Pacientes</a></li>
		<li class="active">Painel</li>
	</ol>
@stop

@section('content')

	<div style="padding: 5px;">
		
		<div class="row">

			
			<div class="col-xs-16 col-sm-8 col-md-8 col-lg-5">
				
				@include('painel_old.paciente')

			</div>

			
			<div class="col-xs-16 col-sm-8 col-md-8 col-lg-5">

				@include('painel_old.tratamentos')

				@if($tratamento)

					@include('painel_old.agenda')
				
				@endif
				
			</div>

			
			<div class="col-xs-16 col-sm-16 col-md-16 col-lg-6">
				
				@include('painel_old.complexidade')

				@include('painel_old.prontuario')

				@if($tratamento)

					<div class="row" style="margin-bottom: 15px;">
						<div class="col-xs-8">
							<a 
								class="btn btn-block btn-default"
								href="{{ route('atividadesEdit', ['id' => $tratamento->id]) }}"
								target="_blank">
								<i class="fa fa-pencil fa-fw"></i>&nbsp;Descrever Relatório
							</a>
						</div>
						<div class="col-xs-8">
							<a 
								href="{{route('report', ['treatment_id' => $tratamento->id])}}"
								class="btn btn-default btn-block"
								style="color: #D95256; font-weight: bold; border-color: #D95256;"
								target="_blank">
								<i class="fa fa-file-text-o fa-fw"></i>&nbsp;Relatório para impressão
							</a>
						</div>
					</div>


					@include('painel_old.protocolos')
					

					@include('painel_old.avaliacoes-antigas')

				@endif
			</div>


		</div>
	</div>

	

	@if($tratamento)

		<!-- Modals -->

		@if (User::allowedCredentials([10], true))
			@include('painel_old.faturamento')
		@endif

		@include('painel_old.logs')

		<!-- Modals -->

	@endif
	

	{{ View::make('layouts.admin.print-footer') }}
@stop
