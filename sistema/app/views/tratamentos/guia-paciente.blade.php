@extends('layouts.admin.template')

@section('head')
	@parent
	<title>Sistema</title>
@stop

@section('main-panel-heading')
	@parent
	<ol class="breadcrumb">
		<li>{{ link_to_route('painel', $t->paciente->nome, ['id' => $t->paciente->id, 'id2' => $t->id]) }}</li>
		<li class="active">Guia Paciente</li>
	</ol>
@stop

@section('content')

    <?php 
    $s = Sistema::parametros();
    $dia = date('d');
    $mes = Lang::get('months.'.date('F'));
    $ano = date('Y');
    ?>

    <div ng-controller="GuiaPacienteController">
        <div class="no-print text-center mb-6">
            <button type="button" class="print-trigger btn btn-default mr-6">
                <i class="fa fa-print fa-lg"></i> Imprimir
            </button>
            @if($t->paciente->email) 
                <button
                    type="button"  
                    class="btn btn-default"
                    ng-click="sendEmailGuiaPaciente('{{ route('tratamentosSendEmail', ['id' => $t->id]) }}')" 
                >
                    <i class="fa fa-envelope-o fa-lg"></i> Enviar para: <strong class="text-primary">{{$t->paciente->email}}</strong>
                </button>
            @else 
                <span class="btb btn-disabled">
                    <i class="fa fa-envelope-o fa-lg"></i> O Email do paciente não está cadastrado
                </span>
            @endif
            <div class="my-3">
                <div id="enable_alert_container" class="row hidden">
                    <div class="col-md-10 col-md-offset-3">
                        <div class="alert alert-info text-lg" ng-if="message_sending">
                            @{{message_sending}}
                            <i class="fa fa-spinner fa-pulse fa-lg fa-fw"></i>
                        </div>
                        <div class="alert alert-success text-lg" ng-if="message_sending_success">
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                            @{{message_sending_success}}
                        </div>
                        <div class="alert alert-danger text-lg" ng-if="message_sending_fail">
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                            @{{message_sending_fail}}
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{ View::make('layouts.admin.print-header') }}

        <div class="row">
            <div class="col-md-3 hidden-print">
                <div class="bg-gray-200 p-2">
                    <div class="checkbox"><label><input type="checkbox" ng-model="display.cabecalho" value="true"> <strong>Cabeçalho</strong></label></div>
                    <div class="pt-1 pl-3">
                        <div class="checkbox"><label><input type="checkbox" ng-model="display.rg" value="true"> RG</label></div>
                        <div class="checkbox"><label><input type="checkbox" ng-model="display.cpf" value="true"> CPF</label></div>
                        <div class="checkbox"><label><input type="checkbox" ng-model="display.endereco" value="true"> Endereço</label></div>
                        <div class="checkbox"><label><input type="checkbox" ng-model="display.cidade" value="true"> Cidade</label></div>
                        <div class="checkbox"><label><input type="checkbox" ng-model="display.telefones" value="true"> Telefones</label></div>
                        <div class="checkbox"><label><input type="checkbox" ng-model="display.datanascimento" value="true"> Data de nascimento</label></div>
                        <div class="checkbox"><label><input type="checkbox" ng-model="display.carteirinha" value="true"> Carteirinha</label></div>
                    </div>
                    <hr class="border border-gray-400">
                    <div class="checkbox"><label><input type="checkbox" ng-model="display.tratamento" value="true"> <strong>Tratamento</strong></label></div>
                    <div class="pt-1 pl-3">
                        <div class="checkbox"><label><input type="checkbox" ng-model="display.iniciotratamento" value="true"> Início do Tratamento</label></div>
                        <div class="checkbox"><label><input type="checkbox" ng-model="display.tipo" value="true"> Tipo</label></div>
                        <div class="checkbox"><label><input type="checkbox" ng-model="display.medico" value="true"> Médico</label></div>
                        <div class="checkbox"><label><input type="checkbox" ng-model="display.profissional" value="true"> Profissional</label></div>
                        <div class="checkbox"><label><input type="checkbox" ng-model="display.convenio" value="true"> Convênio</label></div>
                        <div class="checkbox"><label><input type="checkbox" ng-model="display.datalesao" value="true"> Data da Lesão</label></div>
                        <div class="checkbox"><label><input type="checkbox" ng-model="display.datacirurgia" value="true"> Data da Cirurgia</label></div>
                        <div class="checkbox"><label><input type="checkbox" ng-model="display.lesao" value="true"> Lesão</label></div>
                        <div class="checkbox"><label><input type="checkbox" ng-model="display.membro" value="true"> Membro</label></div>
                        <div class="checkbox"><label><input type="checkbox" ng-model="display.numerosessoes" value="true"> Sessões</label></div>
                    </div>
                    <hr class="border border-gray-400">
                    <div class="checkbox"><label><input type="checkbox" ng-model="display.agenda" value="true"> <strong>Agenda</strong></label></div>
                    <div class="pt-1 pl-3">
                        <div class="checkbox"><label><input type="checkbox" ng-model="display.sessoes" value="true"> Sessões</label></div>
                        <div class="checkbox"><label><input type="checkbox" ng-model="display.datasessao" value="true"> Data</label></div>
                        <div class="checkbox"><label><input type="checkbox" ng-model="display.horasessao" value="true"> Horário</label></div>
                        <div class="checkbox"><label><input type="checkbox" ng-model="display.situacao" value="true"> Situação</label></div>
                        <div class="checkbox"><label><input type="checkbox" ng-model="display.assinatura" value="true"> Assinatura Paciente</label></div>
                    </div>
                    <hr class="border border-gray-400">
                    <div class="checkbox"><label><input type="checkbox" ng-model="display.declaracao" value="true"> <strong>Declaração</strong></label></div>
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
                                <td>
                                    <sup class="block-inline">Endereço</sup>
                                    <div class="-mt-2" ng-if="display.endereco">{{ $t->paciente->endereco }}</div>
                                </td>
                                <td>
                                    <sup class="block-inline">CPF</sup>
                                    <div class="-mt-2" ng-if="display.cpf">{{ $t->paciente->cpf }}</div>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <sup class="block-inline">Cidade</sup>
                                    <div class="-mt-2" ng-if="display.cidade">{{ $t->paciente->cidade->nome }} / {{ $t->paciente->cidade->estado_uf }}</div>
                                </td>
                                <td>
                                    <sup class="block-inline">Data de nascimento</sup>
                                    <div class="-mt-2" ng-if="display.datanascimento">{{ $t->paciente->nascimento }}</div>
                                </td>
                            </tr>
                            <tr>
                                <td>
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
                                <td>
                                    <sup class="block-inline">Carteirinha</sup>
                                    <div class="-mt-2" ng-if="display.carteirinha">{{ $t->paciente->carteirinha }}</div>
                                </td>
                            </tr>
                        </table>
                    </div>
                    <div ng-if="display.tratamento">
                        <div class="text-center text-lg my-8">TRATAMENTO</div>
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
                            <tr>
                                <td>
                                    <sup class="block-inline">Convênio</sup>
                                    <div class="-mt-2" ng-if="display.convenio">
                                        @if ($t->convenio)
                                            {{ $t->convenio->nome }}
                                            @if ($t->convenio->cidade_id)
                                                / {{ $t->convenio->cidade->nome }}
                                                - {{ $t->convenio->cidade->estado_uf }}
                                            @endif
                                        @endif
                                    </div>
                                </td>
                                <td>
                                    <sup class="block-inline">Sessões</sup>
                                    <div class="-mt-2" ng-if="display.numerosessoes">{{ $t->sessoes }}</div>
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
                                <th>
                                    <span ng-if="display.assinatura">Assinatura do paciente</span>
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
                                    <td></td>
                                </tr>
                            @endforeach
                        </table>
                    </div>
                    <div ng-if="display.declaracao">
                        <div class="text-center text-lg my-8">DECLARAÇÃO</div>
                        <div class="mb-6 p-20 text-lg leading-normal text-justify" contenteditable="true">
                            Declaro para os devidos fins que o(a) Sr.(a) <strong>{{$t->paciente->nome}}</strong>, 
                            inscrito no CPF sob o nº <strong>{{$t->paciente->cpf}}</strong>,
                            paciente sob meus cuidados, foi atendido 
                            no dia <strong>{{date('d')}}</strong> 
                            das <strong>00:00</strong> 
                            às <strong>00:00</strong>
                        </div>
                        <div class="mb-20 text-center" contenteditable="true">
                            {{$s['cidade']}}, {{$dia}} de {{$mes}} de {{$ano}}
                        </div>
                        <div class="text-center">
                            <div>
                                <hr class="mb-1 w-2/4 border-gray-600">
                            </div>
                            <div class="mb-3" contenteditable="true">
                                {{ $s['razao_social'] }}
                            </div>
                        </div>
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