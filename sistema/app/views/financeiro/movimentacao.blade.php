@extends('layouts.admin.template')

@section('head')
	@parent
	<title>Sistema</title>
@stop

@section('main-panel-heading')
	@parent
	<ol class="breadcrumb">
		<li>Financeiro</li>
		<li class="active">Movimentação</li>
	</ol>
@stop

@section('content')
    @include('financeiro.modal-transferencia-contas')
    <div ng-controller="ListRecursos">

        <div 
            ng-controller="FinanceiroMovimentacaoController"
            ng-init="init('{{htmlspecialchars(json_encode($init), ENT_QUOTES, 'UTF-8')}}')"
            ng-cloak
        >

            @include('financeiro.filtro-movimentacao')

            <div class="mb-3 no-print">
                <div class="row">
                    <div class="col-sm-10">
                        <button
                            type="button"
                            class="btn btn-success"
                            ng-click="openModalForm('{{route('financeiroCreateReceberAdm')}}')"
                        >
                            <i class="fa fa-plus fa-fw"></i> Recebimento
                        </button>
                        <button
                            type="button"
                            class="btn btn-danger"
                            ng-click="openModalForm('{{route('financeiroCreatePagar')}}')"
                        >
                            <i class="fa fa-minus fa-fw"></i> Pagamento
                        </button>
                        <button
                            type="button"
                            class="btn btn-default"
                            data-toggle="modal" 
                            data-target="#modal_transferencia_contas"
                        >
                            <span class="text-blue-600"><i class="fa fa-exchange"></i> Transferência entre Contas</span>
                        </button>
                        <button
                            type="button"
                            class="btn btn-default"
                            ng-click="pagamentoMultiplo('{{ route('updatePagamento') }}')"
                        >
                            <span class="text-blue-600"><i class="fa fa-check-square"></i> Pagamento</span>
                        </button>
                        <a
                            href="{{ route('financeiroMovimentacaoExcel') }}"
                            class="btn btn-default"
                        >
                            <i class="fa fa-file-excel-o"></i> Exportar para contabilidade
                        </a>
                    </div>
                    <div class="col-sm-6">
                        <div class="shadow bg-white p-2">
                            <div class="row cursor-pointer" ng-click="toggleTotais()">
                                <div class="col-sm-5 text-center text-success">
                                    <div>Entradas</div>
                                    <div ng-show="show_totais">
                                        <strong ng-if="!carregando_dados">@{{movimento.total.credito}}</strong>
                                        <i ng-if="carregando_dados" class="fa fa-lg fa-spinner fa-spin text-gray-400"></i>
                                    </div>
                                    <i ng-show="!show_totais" class="opacity-75 fa fa-lg fa-eye-slash"></i>
                                </div>
                                <div class="col-sm-5 text-center text-danger">
                                    <div>Saídas</div>
                                    <div ng-show="show_totais">
                                        <strong ng-if="!carregando_dados">@{{movimento.total.debito}}</strong>
                                        <i ng-if="carregando_dados" class="fa fa-lg fa-spinner fa-spin text-gray-400"></i>
                                    </div>
                                    <i ng-show="!show_totais" class="opacity-75 fa fa-lg fa-eye-slash"></i>
                                </div>
                                <div class="col-sm-5 text-center text-info">
                                    <div>Saldo</div>
                                    <div ng-show="show_totais">
                                        <strong ng-if="!carregando_dados">@{{movimento.total.saldo}}</strong>
                                        <i ng-if="carregando_dados" class="fa fa-lg fa-spinner fa-spin text-gray-400"></i>
                                    </div>
                                    <i ng-show="!show_totais" class="opacity-75 fa fa-lg fa-eye-slash"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="bg-white shadow-md mt-6">
                <div ng-if="carregando_dados" class="text-center py-12">
                    <i class="fa fa-spinner fa-spin fa-5x text-gray-300"></i>
                </div>
                <table ng-if="!carregando_dados" class="table table-condensed table-bordered valign-middle">
                    <thead>
                        <th class="w-12">ID</th>
                        <th class="no-print w-12"></th>
                        <th class="no-print w-8 text-center">
                            <input type="checkbox" id="pagamentoCheckboxAll">
                        </th>
                        <th class="text-center no-print" style="width:40px;" title="Tipo de Lançamento">Tipo</th>
                        <th style="width:90px;" class="text-center" title="Data em que o Recebimento/Pagamento ocorreu">
                            <span class="text-gray-500">Competência<br>Emissão</span>
                        </th>
                        <th style="width:110px;" class="text-center bg-gray-200">
                            Vencimento <i class="fa fa-sort-asc"></i><br>Previsão
                        </th>
                        <th style="width:90px;" class="text-center bg-gray-200">
                            Pagamento<br>Concluído
                        </th>
                        <th style="width:100px;" class="bg-gray-200 text-right">Valor</th>
                        <th style="width:60px;" class="text-center">Parcela</th>
                        <th>
                            <span class="block" ng-if="filtro.tipomovimentacao_entradas == 1">Emissor</span>
                            <span class="block" ng-if="filtro.tipomovimentacao_saidas == 1">Favorecido</span>
                            <span ng-if="filtro.tipomovimentacao_entradas == 0 && filtro.tipomovimentacao_saidas == 0">
                                <span class="block">Emissor</span>
                                <span class="block">Favorecido</span>
                            </span>
                        </th>
                        <th>Descrição</th>
                        <th style="width:80px;">Código/Guia</th>
                        <th style="width:80px;">Nº Nota Fiscal</th>
                        <th style="min-width: 130px;">Conta</th>
                        <th style="min-width: 130px;">Centro de Custo</th>
                        <th style="min-width: 20px;">Tipo</th>
                    </thead>
                    <tbody class="checkboxContainerArea">
                        <tr 
                            ng-repeat="(idx, row) in movimento.dados track by idx"
                            class="hover:underline border-l-8 @{{ row.border_color }} @{{ row.text_color }} @{{ row.bg_row }}"
                        >
                            <!-- Tipo lançamento -->
                            <td ng-if="!row.readonly" class="no-print text-center">
                                <div class="btn-group">
                                    <button type="button" class="p-1 btn btn-link dropdown-toggle" data-toggle="dropdown">
                                        <i class="fa fa-bars fa-lg fa-fw text-gray-600"></i>
                                    </button>
                                    <ul class="dropdown-menu" role="menu">
                                        <li ng-if="row.pagamento">
                                            <a href="@{{ row.route_recibo }}" target="_blank">
                                                <i class="fa fa-file-text-o fa-fw"></i> Recibo
                                            </a>
                                        </li>
                                        <li ng-if="!row.pagamento">
                                            <a href title="Para gerar o recibo, o lançamento deve estar pago.">
                                                <span class="text-gray-400"><i class="fa fa-file-text-o fa-fw"></i> Recibo</span>
                                            </a>
                                        </li>
                                        <li>
                                            <a href="#" ng-click="buttonDuplicate(row.route_duplicar)">
                                                <i class="fa fa-copy fa-fw"></i> Duplicar
                                            </a>
                                        </li>
                                        <li>
                                            <a
                                                href="@{{ row.route_excluir }}"
                                                class="confirm-destroy">
                                                <i class="fa fa-trash-o fa-fw"></i> Excluir
                                            </a>
                                        </li>
                                    </ul>
                                </div>
                            </td>
                            <td ng-if="!row.readonly" class="text-gray-500">#@{{ row.id }}</td>
                            <td ng-if="!row.readonly" class="text-center">
                                <input
                                    ng-if="!row.pagamento" 
                                    type="checkbox" 
                                    name="ids_pagamento[@{{ row.id }}]" 
                                    value="@{{ row.id }}"
                                >
                            </td>
                            <td ng-if="!row.readonly" class="text-center" title="@{{ row.label_tipo_lancamento }}">
                                <i ng-if="row.tipo_lancamento == 'lote'" ng-click="buttonListarItensLote(row.route_listar_lote)" class="cursor-pointer @{{ row.icone }}"></i>
                                <i ng-if="row.tipo_lancamento != 'lote'" class="@{{ row.icone }}"></i>
                            </td>
                            <td ng-if="!row.readonly" ng-click="openModalForm(row.route_editar)" class="text-center cursor-pointer" style="opacity: 0.70;">
                                @{{ row.emissao }}
                            </td>
                            <td ng-if="!row.readonly" ng-click="openModalForm(row.route_editar)" class="text-center cursor-pointer">
                                @{{ row.vencimento }}
                            </td>
                            <td ng-if="!row.readonly" ng-click="openModalForm(row.route_editar)" class="text-center cursor-pointer">
                                @{{ row.pagamento }}
                            </td>
                            <td ng-if="!row.readonly" ng-click="openModalForm(row.route_editar)" class="cursor-pointer text-right">
                                <span 
                                    class="cursor-pointer"
                                    data-toggle="tooltip" 
                                    data-placement="left"
                                    data-html="true"
                                    data-title="Valor: @{{ row.valor }}<br>Descontos/Taxas: @{{ row.desconto_taxa }}<br>Juros/Multa: @{{ row.juros_multa }}<br>Valor Pago: @{{ row.valor_pago }}" 
                                >
                                    @{{ row.valor_pago }}
                                </span>
                                <i class="@{{ row.icone_status }}">
                            </td>
                            <td ng-if="!row.readonly" ng-click="openModalForm(row.route_editar)" class="text-center cursor-pointer">
                                @{{ row.parcela }}
                            </td>
                            <td ng-if="!row.readonly" ng-click="openModalForm(row.route_editar)" class="cursor-pointer">
                                @{{ row.favorecido }}
                            </td>
                            <td ng-if="!row.readonly" ng-click="openModalForm(row.route_editar)" class="cursor-pointer">
                                @{{ row.descricao }}
                            </td>
                            <td ng-if="!row.readonly" ng-click="openModalForm(row.route_editar)" class="cursor-pointer">
                                @{{ row.codigo }}
                            </td>
                            <td ng-if="!row.readonly" ng-click="openModalForm(row.route_editar)" class="cursor-pointer">
                                @{{ row.nota_fiscal }}
                            </td>
                            <td ng-if="!row.readonly" ng-click="openModalForm(row.route_editar)" class="cursor-pointer">
                                @{{ row.conta }}
                            </td>
                            <td ng-if="!row.readonly" ng-click="openModalForm(row.route_editar)" class="cursor-pointer">
                                @{{ row.tipo_despesa }}
                            </td>
                            <td ng-if="!row.readonly" ng-click="openModalForm(row.route_editar)" class="cursor-pointer">
                                @{{ row.tipo }}
                            </td>
                            <!-- Tipo readonly -->
                            <td ng-if="row.readonly" class="no-print text-center"></td>
                            <td ng-if="row.readonly" class="text-gray-500">#@{{ row.id }}</td>
                            <td ng-if="row.readonly" class="text-center"></td>
                            <td ng-if="row.readonly" title="@{{ row.label_tipo_lancamento }}" class="text-center"><i class="@{{ row.icone }}"></i></td>
                            <td ng-if="row.readonly" class="text-center" style="opacity: 0.70;">@{{ row.emissao }}</td>
                            <td ng-if="row.readonly" class="text-center">@{{ row.vencimento }}</td>
                            <td ng-if="row.readonly" class="text-center">@{{ row.pagamento }}</td>
                            <td ng-if="row.readonly" class="text-right">
                                <span 
                                    class="cursor-pointer"
                                    data-toggle="tooltip" 
                                    data-placement="left"
                                    data-html="true"
                                    data-title="Valor: @{{ row.valor }}<br>Descontos/Taxas: @{{ row.desconto_taxa }}<br>Juros/Multa: @{{ row.juros_multa }}<br>Valor Pago: @{{ row.valor_pago }}" 
                                >
                                    @{{ row.valor_pago }}
                                </span>
                                <i class="@{{ row.icone_status }}">
                            </td>
                            <td ng-if="row.readonly"></td>
                            <td ng-if="row.readonly">@{{ row.favorecido }}</td>
                            <td ng-if="row.readonly">@{{ row.descricao }}</td>
                            <td ng-if="row.readonly">@{{ row.codigo }}</td>
                            <td ng-if="row.readonly">@{{ row.nota_fiscal }}</td>
                            <td ng-if="row.readonly">@{{ row.conta }}</td>
                            <td ng-if="row.readonly">@{{ row.tipo_despesa }}</td>
                            <td ng-if="row.readonly">@{{ row.tipo }}</td>
                        </tr>
                    </tbody>
                </table>
            </div>

        </div><!-- FinanceiroMovimentacaoController -->

    </div><!-- ListRecursos -->
@stop
