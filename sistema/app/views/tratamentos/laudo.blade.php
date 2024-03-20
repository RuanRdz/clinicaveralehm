@extends('layouts.admin.template')

@section('head')
	@parent
	<title>Sistema</title>
@stop

@section('main-panel-heading')
	@parent
	<ol class="breadcrumb">
		<li>{{ link_to_route('painel', $t->paciente->nome, ['id' => $t->paciente->id, 'id2' => $t->id]) }}</li>
		<li class="active">Laudo</li>
	</ol>
@stop

@section('content')

    <div ng-controller="LaudoController">

        <div class="no-print text-center mb-6">
            <a class="btn btn-primary" href="{{ route('tratamentosEditLaudo', ['id' => $t->id]) }}">
                <i class="fa fa-pencil"></i> Editar
            </a>
            <button type="button" class="print-trigger btn btn-default">
                <i class="fa fa-print fa-lg"></i> Imprimir
            </button>
        </div>
    
        {{ View::make('layouts.admin.print-header') }}
    
        <div class="row">
            <div class="col-md-3 hidden-print">
                <div class="bg-gray-200 p-2">
                    <div class="checkbox"><label><input type="checkbox" ng-model="display.rg" value="true"> RG</label></div>
                    <hr class="border border-gray-400">
                    <div class="checkbox"><label><input type="checkbox" ng-model="display.tratamento" value="true"> <strong>Tratamento</strong></label></div>
                    <div class="pt-1 pl-3">
                        <div class="checkbox"><label><input type="checkbox" ng-model="display.iniciotratamento" value="true"> Início do Tratamento</label></div>
                        <div class="checkbox"><label><input type="checkbox" ng-model="display.tipo" value="true"> Tipo</label></div>
                        <div class="checkbox"><label><input type="checkbox" ng-model="display.medico" value="true"> Médico</label></div>
                        <div class="checkbox"><label><input type="checkbox" ng-model="display.profissional" value="true"> Profissional</label></div>
                        <div class="checkbox"><label><input type="checkbox" ng-model="display.datalesao" value="true"> Data da Lesão</label></div>
                        <div class="checkbox"><label><input type="checkbox" ng-model="display.datacirurgia" value="true"> Data da Cirurgia</label></div>
                        <div class="checkbox"><label><input type="checkbox" ng-model="display.lesao" value="true"> Lesão</label></div>
                        <div class="checkbox"><label><input type="checkbox" ng-model="display.membro" value="true"> Membro</label></div>
                    </div>
                    <hr class="border border-gray-400">
                    <div class="checkbox"><label><input type="checkbox" ng-model="display.usoinformacoes" value="true"> Uso de informações</label></div>
                </div>
            </div>
            <div class="col-md-13">
                <div class="p-6 bg-white shadow-md">
                    <table class="table table-condensed">
                        <tr>
                            <td style="width:50%">
                                <sup class="block-inline">Paciente</sup>
                                <div class="-mt-2 font-bold">{{ $t->paciente->nome }}</div>
                            </td>
                            <td style="width:50%">
                                <sup class="block-inline">RG</sup>
                                <div class="-mt-2" ng-if="display.rg">{{ $t->paciente->rg }}</div>
                            </td>
                        </tr>
                    </table>
                    <div ng-if="display.tratamento">
                        <table class="table table-condensed">
                            <tr>
                                <td style="width:50%">
                                    <sup class="block-inline">Início do Tratamento</sup>
                                    <div class="-mt-2" ng-if="display.iniciotratamento">{{ $t->created_at }}</div>
                                </td>
                                <td style="width:50%">
                                    <sup class="block-inline">Data da Lesão</sup>
                                    <div class="-mt-2" ng-if="display.datalesao">{{ $t->data_lesao }}</div>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <sup class="block-inline">Tipo</sup>
                                    <div class="-mt-2" ng-if="display.tipo">{{ $t->tratamentotipo->nome }}</div>
                                </td>
                                <td>
                                    <sup class="block-inline">Data da Cirurgia</sup>
                                    <div class="-mt-2" ng-if="display.datacirurgia">{{ $t->data_cirurgia }}</div>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <sup class="block-inline">Médico</sup>
                                    <div class="-mt-2" ng-if="display.medico">{{ $t->medico ? $t->medico->nome : null }}</div>
                                </td>
                                <td>
                                    <sup class="block-inline">Lesão</sup>
                                    <div class="-mt-2" ng-if="display.lesao">{{ $t->lesao ? $t->lesao->nome : null}}</div>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <sup class="block-inline">Terapeuta Ocupacional / Fisioterapeuta</sup>
                                    <div class="-mt-2" ng-if="display.profissional">
                                        @if($t->terapeuta)
                                            {{ $t->terapeuta->fullNameCrefito }}
                                        @endif
                                    </div>
                                </td>
                                <td>
                                    <sup class="block-inline">Membro</sup>
                                    <div class="-mt-2" ng-if="display.membro">{{ $t->membro ? $t->membro->nome : null }}</div>
                                </td>
                            </tr>
                        </table>
                    </div>
                    <div class="text-center text-lg my-8">TRATAMENTO</div>
                    <div class="mb-12">
                        <div class="show_laudo" align="justify">
                            {{ nl2br($t->laudo) }}
                        </div>
                        <div ng-if="display.usoinformacoes">
                            <hr>
                            Uso de informações autorizada pelo paciente: <strong>{{ $lc[$t->laudo_certificado] }}<strong>
                        </div>
                        <div class="text-center">
                            {{ View::make('layouts.admin.update-assinatura')->with(array('user' => $t))->render() }}
                            <hr style="width: 60%; margin-top: 5px; margin-bottom: 5px;">
                            Profissional: 
                            @if($t->updatedBy) 
                                {{$t->updatedBy->fullName}}
                                @if($t->updatedBy->crefito)
                                CREFITO {{ $t->updatedBy->crefito }}
                                @endif
                            @else 
                                {{$t->createdBy->fullName}}
                                @if($t->createdBy->crefito)
                                    - {{ $t->createdBy->crefito }}
                                @endif
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{ View::make('layouts.admin.print-footer') }}
    </div>


@stop