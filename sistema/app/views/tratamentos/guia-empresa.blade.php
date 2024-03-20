@extends('layouts.admin.template')

@section('head')
	@parent
	<title>Sistema</title>
@stop

@section('main-panel-heading')
	@parent
	<ol class="breadcrumb">
		<li>{{ link_to_route('painel', $t->paciente->nome, ['id' => $t->paciente->id, 'id2' => $t->id]) }}</li>
		<li class="active">Guia Empresa</li>
	</ol>
@stop

@section('content')

    <div ng-controller="GuiaEmpresaController">
        <div class="no-print text-center mb-6">
            <button type="button" class="print-trigger btn btn-default">
                <i class="fa fa-print fa-lg"></i> Imprimir
            </button>
        </div>
    
        {{ View::make('layouts.admin.print-header') }}
    
        <div class="row">
            <div class="col-md-3 hidden-print">
                <div class="bg-gray-200 p-2">
                    <div class="checkbox"><label><input type="checkbox" ng-model="display.cabecalho" value="true"> <strong>Cabeçalho</strong></label></div>
                    <div class="pt-1 pl-3">
                        <div class="checkbox"><label><input type="checkbox" ng-model="display.rg" value="true"> RG</label></div>
                        <div class="checkbox"><label><input type="checkbox" ng-model="display.telefones" value="true"> Telefones</label></div>
                    </div>
                    <hr class="border border-gray-400">
                    <div class="checkbox"><label><input type="checkbox" ng-model="display.tratamento" value="true"> <strong>Tratamento</strong></label></div>
                    <div class="pt-1 pl-3">
                        <div class="checkbox"><label><input type="checkbox" ng-model="display.tipo" value="true"> Tipo</label></div>
                        <div class="checkbox"><label><input type="checkbox" ng-model="display.profissional" value="true"> Profissional</label></div>
                        <div class="checkbox"><label><input type="checkbox" ng-model="display.lesao" value="true"> Lesão</label></div>
                        <div class="checkbox"><label><input type="checkbox" ng-model="display.numerosessoes" value="true"> Sessões</label></div>
                    </div>
                    <hr class="border border-gray-400">
                    <div class="checkbox"><label><input type="checkbox" ng-model="display.agenda" value="true"> <strong>Agenda</strong></label></div>
                    <div class="pt-1 pl-3">
                        <div class="checkbox"><label><input type="checkbox" ng-model="display.sessoes" value="true"> Sessões</label></div>
                        <div class="checkbox"><label><input type="checkbox" ng-model="display.datasessao" value="true"> Data</label></div>
                        <div class="checkbox"><label><input type="checkbox" ng-model="display.horasessao" value="true"> Horário</label></div>
                        <div class="checkbox"><label><input type="checkbox" ng-model="display.situacao" value="true"> Situação</label></div>
                    </div>
                </div>
            </div>
            <div class="col-md-13">
                <div class="p-6 bg-white shadow-md">
                    <div ng-if="display.cabecalho">
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
                            <tr>
                                <td colspan="2">
                                    <sup class="block-inline">Telefones</sup>
                                    <div class="-mt-2" ng-if="display.telefones">
                                        @if (!empty($t->paciente->fone_residencial))
                                            Res:
                                            {{ $t->paciente->fone_residencial }}
                                            &nbsp;&nbsp;
                                        @endif
                                        @if (!empty($t->paciente->fone_celular))
                                            Cel:
                                            {{ $t->paciente->fone_celular }}
                                            @if (!empty($t->paciente->operadora_celular))
                                                ({{ $t->paciente->operadora_celular }})
                                            @endif
                                            &nbsp;&nbsp;
                                        @endif
                                        @if (!empty($t->paciente->fone_comercial))
                                            Com:
                                            {{ $t->paciente->fone_comercial }}
                                            &nbsp;&nbsp;
                                        @endif
                                        @if (!empty($t->paciente->fone_recado))
                                            Recado:
                                            {{ $t->paciente->fone_recado }}
                                        @endif
                                    </div>
                                </td>
                            </tr>
                        </table>
                    </div>
                    <div ng-if="display.tratamento">
                        <div class="text-center text-lg my-8">TRATAMENTO</div>
                        <table class="table table-condensed">
                            <tr>
                                <td style="width: 50%">
                                    <sup class="block-inline">Tipo</sup>
                                    <div class="-mt-2" ng-if="display.tipo">{{ $t->tratamentotipo->nome }}</div>
                                </td>
                                <td style="width: 50%">
                                    <sup class="block-inline">Lesão</sup>
                                    <div class="-mt-2" ng-if="display.lesao">{{ $t->lesao ? $t->lesao->nome : null}}</div>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <sup class="block-inline">Sessões</sup>
                                    <div class="-mt-2" ng-if="display.numerosessoes">{{ $t->sessoes }}</div>
                                </td>
                                <td>
                                    <sup class="block-inline">Abertura</sup>
                                    <div class="-mt-2" ng-if="display.iniciotratamento">{{ $t->created_at }}</div>
                                </td>
                            </tr>
                            <tr>
                                <td colspan="2">
                                    <sup class="block-inline">Terapeuta Ocupacional / Fisioterapeuta</sup>
                                    <div class="-mt-2" ng-if="display.profissional">
                                        @if($t->terapeuta)
                                            {{ $t->terapeuta->fullNameCrefito }}
                                        @endif
                                    </div>
                                </td>
                            </tr>
                        </table>
                    </div>
                    <div ng-if="display.agenda">
                        <div class="text-center text-lg my-8">AGENDA</div>
                        <table class="table table-condensed">
                            <tr>
                                <th style="width: 10%;">
                                    <span ng-if="display.sessoes">Sessão</span>
                                </th>
                                <th style="width: 15%;">
                                    <span ng-if="display.datasessao">Data sessão</span>
                                </th>
                                <th style="width: 15%;">
                                    <span ng-if="display.horasessao">Horário</span>
                                </th>
                                <th style="width: 20%;">
                                    <span ng-if="display.situacao">Situação</span>
                                </th>
                            </tr>
                            @foreach ($t->agendas()->orderBy('sessao')->get() as $row)
                                <tr>
                                    <td>
                                        <span ng-if="display.sessoes">{{ $row->sessao }}</span>
                                    </td>
                                    <td>
                                        <span ng-if="display.datasessao">
                                            @if($row->data_sessao)
                                                {{ diaBr(date('D', strtotime($row->data_sessao))) }},
                                                {{ $row->data_sessao }}
                                            @endif
                                        </span>
                                    </td>
                                    <td>
                                        <span ng-if="display.horasessao">{{ horarios()[$row->inicio] }}</span>
                                    </td>
                                    <td>
                                        <span ng-if="display.situacao">{{ $row->agendasituacao->nome_sumario }}</span>
                                    </td>
                                </tr>
                            @endforeach
                        </table>
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

        {{ View::make('layouts.admin.print-footer') }}
    </div>
@stop