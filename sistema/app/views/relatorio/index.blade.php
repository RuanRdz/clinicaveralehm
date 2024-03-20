@extends('layouts.admin.template')

@section('head')
	@parent
	<title>Sistema</title>
@stop

@section('main-panel-heading')
	@parent
	<ol class="breadcrumb">
		<li>{{ link_to_route('painel', $t->paciente->nome, ['id' => $t->paciente->id, 'id2' => $t->id]) }}</li>
		<li class="active">Relatório</li>
	</ol>
@stop

@section('content')
    
    <div class="no-print text-center mb-6">
        <button type="button" class="print-trigger btn btn-default">
            <i class="fa fa-print fa-lg"></i> Imprimir
        </button>
	</div>

	{{ View::make('layouts.admin.print-header') }}

	@include('relatorio.index.header')

	<p class="report-title">RELATÓRIO</p>

	<table style="width: 100%!important; padding: 0!important; margin: 0!important;">
		<tr>
			<td style="width: 60%!important; vertical-align: top!important; padding: 0!important; padding-right: 10px!important; margin: 0!important;">
				@if(in_array('B', $dadosControle))
					@include('relatorio.index.realizamos')
				@endif
			</td>
			<td style="width: 40%!important; vertical-align: top!important; padding: 0!important; margin: 0!important;">
				@if(in_array('A', $dadosControle))
					@include('relatorio.index.mapeamento')
				@endif
			</td>
		</tr>
	</table>

	@if(in_array('TF', $dadosControle))
		@if (count($tabelaforca) > 0)
			@include('relatorio.index.tabela-forca')
		@endif
	@endif

	@if(in_array('TFM', $dadosControle))
		@if (count($testeforcatratamentos) > 0)
			@include('relatorio.index.teste-forca')
		@endif
	@endif

	@if(in_array('AM', $dadosControle))
		@if (count($amplitudetratamentos) > 0)
			@include('relatorio.index.amplitude-movimento')
		@endif
	@endif

	@if(in_array('TU', $dadosControle))
		@include('relatorio.index.terminologia-uniforme')
	@endif

	@if(in_array('C', $dadosControle))
		@include('relatorio.index.atividades')
	@endif

	@include('relatorio.index.paciente-retorno')

	{{ View::make('layouts.admin.print-footer') }}

@stop
