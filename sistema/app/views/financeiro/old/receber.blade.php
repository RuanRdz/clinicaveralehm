@extends('layouts.admin.template')

@section('head')
	@parent
	<title>Sistema</title>
@stop

@section('main-panel-heading')
	@parent
	<ol class="breadcrumb">
		<li>Financeiro</li>
		<li class="active">Pacientes</li>
	</ol>
@stop

@section('content')
    @include('financeiro.filtro-receber')
    <div ng-controller="ListRecursos">
        <div class="row mb-3 no-print">
            <div class="col-sm-8">
                <a
                    href="{{ route('updatePagamento') }}"
                    id="receberButton"
                    class="btn btn-info"
                >
                    <i class="fa fa-plus-square"></i> Gerar Entrada
                </a>
                <button
                    type="button"
                    class="btn btn-warning"
                    data-toggle="modal" 
                    data-target="#modal_filtro_receber_particular"
                >
                    <i class="fa fa-filter"></i> Filtro
                </button>
                <a
                    href="{{ route('financeiroReceberExcel') }}"
                    class="btn btn-default"
                >
                    <i class="fa fa-file-excel-o"></i> Exportar
                </a>
            </div>
            <div class="col-sm-8 text-right">
                {{ $financeiro->links() }}
            </div>
        </div>
        <div class="bg-white shadow-md">
            <table class="table table-condensed table-bordered table-hover valign-middle">
                <thead>
                    <th class="no-print w-4"></th>
                    <th class="no-print w-4 bg-blue-300">
                        <input type="checkbox" id="receberCheckboxAll">
                    </th>
                    <th>Paciente</th>
                    <th>Observação</th>
                    <th style="width:130px;">Convênio</th>
                    <th style="width:80px;" class="bg-gray-200">Emissão</th>
                    <th style="width:80px;" class="bg-gray-200">Vencimento</th>
                    <th style="width:70px;" class="bg-gray-200 text-right">Valor</th>
                    <th title="Forma de pagamento">Forma Pgto.</th>
                    <th>Conta</th>
                    <th>Documento</th>
                    <th style="width:70px;">Tratamento</th>
                    <th style="width:70px;" title="Data da primeira sessão">Pri. Sessão</th>
                    <th style="width:70px;" title="Data da última sessão">Últ. Sessão</th>
                    <th style="width:50px;">Código</th>
                </thead>
                <tbody id="receberCheckboxContainer">
                    @foreach($financeiro as $row)
                        @if ($row->pagamento)
                            <tr class="border-l-8 border-green-400 bg-green-100">
                        @elseif (!$row->pagamento && (brDateToDatabase($row->vencimento) < date('Y-m-d')))
                            <tr class="border-l-8 border-red-400 bg-red-200">
                        @else
                            <tr class="border-l-8 border-blue-400">
                        @endif
                            <td class="no-print text-center">
                                <div class="btn-group">
                                    <button type="button" class="btn btn-link dropdown-toggle" data-toggle="dropdown">
                                        <i class="fa fa-bars fa-lg fa-fw text-gray-600"></i>
                                    </button>
                                    <ul class="dropdown-menu" role="menu">
                                        <li>
                                            <a href="#" ng-click="openModalForm('{{ route('financeiroEditReceber', ['id' => $row->id]) }}')">
                                                <i class="fa fa-pencil fa-fw"></i> Editar
                                            </a>
                                        </li>
                                        <li class="divider"></li>
                                        <li>
                                            @if($row->pagamento)
                                                <a href="{{ route('financeiroGerarRecibo', ['id' => $row->id]) }}" target="_blank">
                                                    <i class="fa fa-file-text-o fa-fw"></i> Recibo
                                                </a>
                                            @else 
                                                <a href title="Para gerar o recibo, o lançamento deve estar pago.">
                                                    <span class="text-gray-400"><i class="fa fa-file-text-o fa-fw"></i> Recibo</span>
                                                </a>
                                            @endif
                                        </li>
                                        <li>
                                            <a href="#" ng-click="buttonDuplicate('{{ route('financeiroDuplicate', ['id' => $row->id]) }}')">
                                                <i class="fa fa-copy fa-fw"></i> Duplicar
                                            </a>
                                        </li>
                                        <li>
                                            <a
                                                href="{{ route('financeiroDestroy', ['id' => $row->id]) }}"
                                                class="confirm-destroy">
                                                <i class="fa fa-trash-o fa-fw"></i> Excluir
                                            </a>
                                        </li>
                                        <li class="divider"></li>
                                        @if (!is_null($row->tratamento))
                                            @if (!is_null($row->tratamento->paciente))
                                                <li>
                                                    <a href="{{ route('painel', ['id' => $row->tratamento->paciente->id, 'id2' => $row->tratamento->id]) }}">
                                                        <i class="fa fa-share fa-fw"></i> Ir para o painel do paciente
                                                    </a>
                                                </li>
                                            @endif
                                        @endif
                                    </ul>
                                </div>
                            </td>

                            <td class="no-print text-center">
                                @if (!$row->pagamento)
                                    <input type="checkbox" name="receber[{{ $row->id }}]" value="{{ $row->id }}">
                                @endif
                            </td>
                            <td>
                                @if (!is_null($row->tratamento))
                                    @if (!is_null($row->tratamento->paciente))
                                        {{ $row->tratamento->paciente->nome }}
                                    @endif
                                @endif
                            </td>
                            <td>{{ $row->observacao }}</td>
                            <td>
                                @if (!is_null($row->tratamento))
                                    {{ !is_null($row->tratamento->convenio) ? $row->tratamento->convenio->nome : '' }}
                                @endif
                            </td>
                            <td>{{ $row->emissao }}</td>
                            <td class="font-bold">{{ $row->vencimento }}</td>
                            <td class="font-bold text-right">{{ $row->valor }}</td>
                            <td>{{ !is_null($row->formapagamento) ? $row->formapagamento->nome : '' }}</td>
                            <td>{{ !is_null($row->conta) ? $row->conta->nome : '' }}</td>
                            <td>{{ !is_null($row->documento) ? $row->documento->nome : '' }}</td>
                            @if (!is_null($row->tratamento))
                                <td>{{ $row->tratamento->created_at }}</td>
                                <td>{{ timestampToBr($row->data_primeira_sessao) }}</td>
                                <td>{{ timestampToBr($row->data_ultima_sessao) }}</td>
                                <td>{{ $row->tratamento->id }}</td>
                            @else 
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                            @endif
                        </tr>
                    @endforeach
                </tbody>
                <tfoot>
                    <tr>
                        <th colspan="5" class="text-right">Total {{ $total }}</thclass>
                    </tr>
                </tfoot>
            </table>
        </div>
        <div class="text-right">
            {{ $financeiro->links() }}
        </div>
    </div>
@stop
