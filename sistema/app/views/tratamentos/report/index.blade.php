@extends('layouts.admin.template')

@section('head')
	@parent
    <title>Sistema</title>
@stop

@section('main-panel-heading')
	@parent
	<ol class="breadcrumb">
		<li>
            {{ link_to_route(
                'painel', 
                $treatment->paciente->nome, 
                ['id' => $treatment->paciente->id, 'id2' => $treatment->id]) }}
        </li>
		<li class="active">Relatório</li>
	</ol>
@stop

@section('content')

	<!-- Form Configurações -->
    @include('tratamentos.report.form-filter')
    
    <div class="no-print text-center mb-6">
        <button type="button" class="print-trigger btn btn-primary">
            <i class="fa fa-print fa-lg"></i> Imprimir
        </button>
		<button type="button" class="btn btn-info js-btn-show-report-form-configs">
			<i class="fa fa-cog"></i> Configurações
		</button>
	</div>
    
    <div class="row">
        <div class="col-lg-14 col-lg-offset-1">
            <table class="report-container">
                <thead class="report-header">
                    <tr>
                        <th>
                            {{ View::make('layouts.admin.print-header') }}
                        </th>
                    </tr>
                </thead>
                <tfoot class="report-footer only-print">
                    <tr>
                        <td>
                            <table style="width: 100%;">
                                <tr>
                                    <td style="width: 50%; text-align: center;">
                                        <div style="height: 40px!important;"></div>
                                        Paciente: {{ $patient_name }}
                                    </td>
                                    <td style="text-align: center;">
                                        @if($treatment->terapeuta->assinatura) 
                                            <div>
                                                <img src="{{$treatment->terapeuta->url_assinatura}}" style="display: inline; height: 40px!important;"/>
                                            </div>
                                        @endif
                                        Profissional: 
                                        {{$treatment->terapeuta->fullName}}
                                        @if($treatment->terapeuta->crefito)
                                            CREFITO {{ $treatment->terapeuta->crefito }}
                                        @endif
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <hr>
                            {{ View::make('layouts.admin.print-footer') }}
                        </td>
                    </tr>
                </tfoot>
                <tbody class="report-content">
                    <tr>
                        <td>
                            <!-- report -->
        
                                <!-- Cabeçalho -->
                                <div class="js-report-content">
                                    <div class="report-control">
                                        <i 
                                            class="fa fa-lg fa-window-close-o hidden-print js-btn-control-content text-muted" 
                                            title="[Mostrar / Não mostrar] na impressão"></i>
                                    </div>
                                    @include('tratamentos.report.header')
                                </div>
        
                                <!-- Relatório -->
        
                                @include('tratamentos.report.data.realizamos')
        
                                @if($estesiometro['has-data'])
                                    <div class="js-report-content">
                                        @include('tratamentos.report.page-control')
                                        @include('protocols.tests.estesiometro.data.grid', array(
                                            'routePath' => 'estesiometro.data',
                                            'test' => $estesiometro['test'],
                                            'testData' => $estesiometro['data'],  
                                            'scale' => $estesiometro['scale']
                                        ))
                                    </div>
                                @endif
        
                                @if($dor['has-data'])
                                    <div class="js-report-content">
                                        @include('tratamentos.report.page-control')
                                        @include('protocols.tests.dor.data.grid', array(
                                            'routePath' => 'dor.data',
                                            'test' => $dor['test'],
                                            'testData' => $dor['data'],  
                                            'scale' => $dor['scale'],
                                            'types' => $dor['types']
                                        ))
                                    </div>
                                @endif
        
                                @if($forca['has-data'])
                                    <div class="js-report-content">
                                        @include('tratamentos.report.page-control')
                                        @include('protocols.tests.forca.data.grid', array(
                                            'routePath' => 'forca.data',
                                            'test' => $forca['test'],
                                            'testData' => $forca['data']
                                        ))
                                    </div>
                                @endif
        
                                @if($funcaomuscular['has-data'])
                                    <div class="js-report-content">
                                        @include('tratamentos.report.page-control')
                                        @include('protocols.tests.funcaomuscular.data.grid', array(
                                            'routePath' => 'funcaomuscular.data',
                                            'test' => $funcaomuscular['test'],
                                            'testData' => $funcaomuscular['data'],
                                            'scale' => $funcaomuscular['scale']
                                        ))
                                    </div>
                                @endif
        
                                @if($kapandji['has-data'])
                                    <div class="js-report-content">
                                        @include('tratamentos.report.page-control')
                                        @include('protocols.tests.kapandji.data.grid', array(
                                            'routePath' => 'kapandji.data',
                                            'test' => $kapandji['test'],
                                            'testData' => $kapandji['data'],  
                                            'scale' => $kapandji['scale'],
                                            'sides' => $kapandji['sides'],
                                        ))
                                    </div>
                                @endif
        
                                @if($goniometro['has-data'])
                                    <div class="js-report-content">
                                        @include('tratamentos.report.page-control')
                                        @include('protocols.tests.goniometro.data.grid', array(
                                            'routePath' => 'goniometro.data',
                                            'test' => $goniometro['test'],
                                            'testData' => $goniometro['data']
                                        ))
                                    </div>
                                @endif
        
                                @if($jebsen['has-data'])
                                    <div class="js-report-content">
                                        @include('tratamentos.report.page-control')
                                        @include('protocols.tests.jebsen.data.grid', array(
                                            'routePath' => 'jebsen.data',
                                            'test' => $jebsen['test'],
                                            'params' => $jebsen['params'],
                                            'testData' => $jebsen['data']
                                        ))
                                    </div>
                                @endif
        
                                @if($avds['has-data'])
                                    <div class="js-report-content">
                                        @include('tratamentos.report.page-control')
                                        @include('protocols.tests.avds.data.grid', array(
                                            'routePath' => 'avds.data',
                                            'test' => $avds['test'],
                                            'testData' => $avds['data'],  
                                            'scale' => $avds['scale']
                                        ))
                                    </div>
                                @endif
        
                                @if($tu['has-data'])
                                    <div class="js-report-content">
                                        @include('tratamentos.report.page-control')
                                        @include('protocols.tests.terminologiauniforme.data.grid')
                                    </div>
                                @endif
                                
                                @include('tratamentos.report.data.paciente-retorno')
        
                            <!-- report -->
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>

@stop
