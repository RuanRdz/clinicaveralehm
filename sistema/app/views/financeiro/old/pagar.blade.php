@extends('layouts.admin.template')

@section('head')
	@parent
	<title>Sistema</title>
@stop

@section('main-panel-heading')
	@parent
	<ol class="breadcrumb">
		<li>Financeiro</li>
		<li class="active">Saídas</li>
	</ol>
@stop

@section('content')
    @include('financeiro.filtro-pagar')
    <div ng-controller="ListRecursos">
        <div class="row mb-3 no-print">
            <div class="col-sm-8">
                <button
                    type="button"
                    class="btn btn-primary"
                    ng-click="openModalForm('{{route('financeiroCreatePagar')}}')"
                >
                    <i class="fa fa-plus fa-fw"></i> Novo Lançamento
                </button>
                <a
                    href="{{ route('updatePagamento') }}"
                    id="receberButton"
                    class="btn btn-info"
                >
                    <i class="fa fa-check-square-o"></i> Pagar Selecionados
                </a>
                <button
                    type="button"
                    class="btn btn-warning"
                    data-toggle="modal" 
                    data-target="#modal_filtro_pagar"
                >
                    <i class="fa fa-filter"></i> Filtro
                </button>
                <a
                    href="{{ route('financeiroPagarExcel') }}"
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
                    <th>Fornecedor</th>
                    <th>Parcela</th>
                    <th>Descrição</th>
                    <th style="width:70px;" class="bg-gray-200 text-right">Valor</th>
                    <th style="width:70px;" class="bg-gray-200">Vencimento</th>
                    <th style="width:70px;" class="bg-gray-200">Pagamento</th>
                    <th>Forma Pgto.</th>
                    <th>Conta</th>
                    <th style="width:70px;" class="bg-gray-200">Emissão</th>
                    <th>Código</th>
                    <th>Documento</th>
                    <th>Tipo Despesa</th>
                    <th>Centro de Custo</th>
                    <th>Cidade</th>
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
                            <td class="no-print">
                                <div class="btn-group">
                                    <button type="button" class="btn btn-link dropdown-toggle" data-toggle="dropdown">
                                        <i class="fa fa-bars fa-lg fa-fw text-gray-600"></i>
                                    </button>
                                    <ul class="dropdown-menu" role="menu">
                                        <li>
                                            <a href="#" ng-click="openModalForm('{{ route('financeiroEditPagar', ['id' => $row->id]) }}')">
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
                                    </ul>
                                </div>
                            </td>
                            <td class="no-print text-center">
                                @if (!$row->pagamento)
                                    <input type="checkbox" name="receber[{{ $row->id }}]" value="{{ $row->id }}">
                                @endif
                            </td>
                            <td>{{ !is_null($row->fornecedor) ? $row->fornecedor->nome : '' }}</td>
                            <td>{{ $row->parcela }}</td>
                            <td>{{ $row->descricao }}</td>
                            <td class="font-bold text-right">{{ $row->valor }}</td>
                            <td style="width: 90px;" class="font-bold">{{ $row->vencimento }}</td>
                            <td style="width: 90px;" class="font-bold">{{ $row->pagamento }}</td>
                            <td>{{ !is_null($row->formapagamento) ? $row->formapagamento->nome : '' }}</td>
                            <td>{{ !is_null($row->conta) ? $row->conta->nome : '' }}</td>
                            <td style="width: 90px;">{{ $row->emissao }}</td>
                            <td>{{ $row->codigo }}</td>
                            <td>{{ !is_null($row->documento) ? $row->documento->nome : '' }}</td>
                            <td>{{ !is_null($row->tipodespesa) ? $row->tipodespesa->nome : '' }}</td>
                            <td>{{ !is_null($row->centrocusto) ? $row->centrocusto->nome : '' }}</td>
                            <td>{{ !is_null($row->cidade) ? $row->cidade->nome.' - '.$row->cidade->estado_uf : '' }}</td>
                        </tr>
                    @endforeach
                </tbody>
                <tfoot>
                    <tr>
                        <th  colspan="7" class="text-right">Total {{ $total }}</thclass>
                    </tr>
                </tfoot>
            </table>
        </div>
        <div class="text-right">
            {{ $financeiro->links() }}
        </div>
    </div>
@stop
