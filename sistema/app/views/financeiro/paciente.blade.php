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
    @include('financeiro.filtro-paciente')
    <div ng-controller="ListRecursos">
        <div ng-controller="FinanceiroPacienteController">
            @include('financeiro.modal-gerar-entrada')
            <div class="row mb-3 no-print">
                <div class="col-sm-8">
                    @if(User::allowedCredentials([10], true))
                        <button
                            class="btn btn-info"
                            ng-click="gerarEntrada()"
                        >
                            <i class="fa fa-check-square"></i> Gerar Entrada
                        </button>
                    @endif
                    <button
                        type="button"
                        class="btn btn-warning"
                        data-toggle="modal" 
                        data-target="#modal_filtro_receber_particular"
                    >
                        <i class="fa fa-filter"></i> Filtro
                    </button>
                    <span class="m-1 p-1 text-gray-500 shadow" title="Período">
                        {{Session::get('filtro_financeiro.data_inicial')}}
                        Até
                        {{Session::get('filtro_financeiro.data_final')}}
                    </span>
                    <?php /* 
                    @if(Session::get('filtro_financeiro.tipo_data'))<span class="m-1 p-1 shadow" title="Data">{{$filtroOptions['tipodata'][Session::get('filtro_financeiro.tipo_data')]}}</span>@endif
                    @if(Session::get('filtro_financeiro.situacao'))<span class="m-1 p-1 shadow" title="Situação">{{$filtroOptions['situacao'][Session::get('filtro_financeiro.situacao')]}}</span>@endif
                    @if(Session::get('filtro_financeiro.convenio_id'))<span class="m-1 p-1 shadow" title="Convênio">{{$filtroOptions['convenio'][Session::get('filtro_financeiro.convenio_id')]}}</span>@endif
                    @if(Session::get('filtro_financeiro.conta_id'))<span class="m-1 p-1 shadow" title="Conta">{{$filtroOptions['conta'][Session::get('filtro_financeiro.conta_id')]}}</span>@endif
                    @if(Session::get('filtro_financeiro.documento_id'))<span class="m-1 p-1 shadow" title="Documento">{{$filtroOptions['documento'][Session::get('filtro_financeiro.documento_id')]}}</span>@endif
                    @if(Session::get('filtro_financeiro.terapeuta_id'))<span class="m-1 p-1 shadow" title="Profissional">{{$filtroOptions['terapeutas'][Session::get('filtro_financeiro.terapeuta_id')]}}</span>@endif
                    */?>
                </div>

                <div class="col-sm-8 text-right">
                    <a
                        href="{{ route('financeiroReceberExcel') }}"
                        class="btn btn-default"
                    >
                        <i class="fa fa-file-excel-o"></i> Exportar
                    </a>
                </div>
            </div>
            
            <div class="bg-white shadow-md">
                <table class="table table-condensed table-bordered valign-middle">
                    <thead>
                        <th class="w-8">ID</th>
                        <th class="no-print w-12"></th>
                        <th class="no-print w-8 text-center bg-blue-300">
                            <input type="checkbox" id="entradaCheckboxAll">
                        </th>
                        <th style="width:60px;" class="text-center">Lote</th>
                        <th style="width:90px;" class="text-center text-gray-500" title="Data em que o Recebimento/Pagamento ocorreu">
                            Competência<br>Emissão
                        </th>
                        <th style="width:100px;" class="text-center bg-gray-200">
                            Vencimento <i class="fa fa-sort-asc"></i><br>Previsão
                        </th>
                        <th style="width:90px;" class="text-center bg-gray-200">
                            Pagamento<br>Concluído
                        </th>
                        <th style="width:70px;" class="bg-gray-200 text-right">Valor</th>
                        <th style="width:50px;" class="text-center">Parcela</th>
                        <th style="width:130px;" class="font-bold">Convênio</th>
                        <th>Paciente</th>
                        <th>Observação</th>
                        <th style="width:80px;">Código/Guia</th>
                        <th style="width:80px;">Nº Nota Fiscal</th>
                        <th style="width:110px;" title="Forma de Pagamento">Forma de Pgto.</th>
                        <th>Conta</th>
                        <th style="width:100px;">Tratamento</th>
                        <th style="width:20px;">Tipo</th>
                    </thead>
                    <tbody class="checkboxContainerArea">
                        <?php $total_valor = $total_valor_pago = 0;?>
                        @foreach($financeiro as $row)
                            <?php 
                            $total_valor += $row->getOriginal('valor');
                            $total_valor_pago += $row->getOriginal('valor_pago');
                            ?>
                            @if ($row->pagamento)
                                <tr class="hover:underline bg-success">
                            @elseif (!$row->pagamento && (brDateToDatabase($row->vencimento) < date('Y-m-d')))
                                <tr class="hover:underline bg-danger">
                            @else
                                <tr class="hover:underline">
                            @endif
                                <td class="text-gray-500">#{{ $row->id }}</td>
                                <td class="no-print text-center">
                                    <div class="btn-group">
                                        <button type="button" class="p-1 btn btn-link dropdown-toggle" data-toggle="dropdown">
                                            <i class="fa fa-bars fa-lg fa-fw text-gray-600"></i>
                                        </button>
                                        <ul class="dropdown-menu" role="menu">
                                            @if(!$row->tipo_lancamento && !$row->lote)
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
                                            @endif 
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
                                @if (!$row->tipo_lancamento && !$row->lote)
                                    <td class="no-print text-center bg-blue-300">
                                        <input 
                                            type="checkbox" 
                                            name="entrada[]" 
                                            data-id="{{ $row->id }}"
                                            data-valor="{{ $row->valor }}"
                                            data-desconto_taxa="{{ $row->desconto_taxa }}"
                                            data-juros_multa="{{ $row->juros_multa }}"
                                            data-valor_pago="{{ $row->valor_pago }}"
                                        >
                                    </td>
                                @else 
                                    <td class="no-print text-center bg-green-300">
                                        <i class="fa fa-check text-green-500"></i>
                                    </td>
                                @endif
                                <td ng-click="openModalForm('{{ route('financeiroEditReceber', ['id' => $row->id]) }}')" class="text-center cursor-pointer">
                                    @if($row->lote)
                                        <span title="Vinculado ao Lote: {{ $row->lote }}">{{ $row->lote }}</span>
                                    @elseif($row->tipo_lancamento)
                                        <span title="Lançado individualmente">( i )</span>
                                    @endif
                                </td>
                                @if(!$row->tipo_lancamento && !$row->lote)
                                    <td ng-click="openModalForm('{{ route('financeiroEditReceber', ['id' => $row->id]) }}')" class="text-center cursor-pointer" style="opacity: 0.70;">
                                        {{ $row->emissao }}
                                    </td>
                                    <td ng-click="openModalForm('{{ route('financeiroEditReceber', ['id' => $row->id]) }}')" class="text-center cursor-pointer">
                                        {{ $row->vencimento }}
                                    </td>
                                    <td ng-click="openModalForm('{{ route('financeiroEditReceber', ['id' => $row->id]) }}')" class="text-center cursor-pointer">
                                        {{ $row->pagamento }}
                                    </td>
                                    <td ng-click="openModalForm('{{ route('financeiroEditReceber', ['id' => $row->id]) }}')" class="cursor-pointer font-bold text-right">
                                        <span 
                                            class="cursor-pointer"
                                            data-toggle="tooltip" 
                                            data-placement="left"
                                            data-html="true"
                                            data-title="Valor: {{ $row->valor }}<br>Descontos/Taxas: {{ $row->desconto_taxa }}<br>Juros/Multa: {{ $row->juros_multa }}<br>Valor Pago: {{ $row->valor_pago }}" 
                                        >
                                            {{ $row->valor_pago }}
                                        </span>
                                    </td>
                                    <td ng-click="openModalForm('{{ route('financeiroEditReceber', ['id' => $row->id]) }}')" class="text-center cursor-pointer">
                                        {{ $row->parcela ? $row->parcela : 1 }}
                                    </td>
                                    <td ng-click="openModalForm('{{ route('financeiroEditReceber', ['id' => $row->id]) }}')" class="cursor-pointer">
                                        @if(!is_null($row->tratamento))
                                            @if(!is_null($row->tratamento->convenio))
                                                {{$row->tratamento->convenio->nome}}
                                            @endif
                                        @endif
                                    </td>
                                    <td ng-click="openModalForm('{{ route('financeiroEditReceber', ['id' => $row->id]) }}')" class="cursor-pointer">
                                        @if(!is_null($row->tratamento))
                                            @if(!is_null($row->tratamento->paciente))
                                                {{ $row->tratamento->paciente->nome }}
                                            @endif
                                        @endif
                                    </td>
                                    <td ng-click="openModalForm('{{ route('financeiroEditReceber', ['id' => $row->id]) }}')" class="cursor-pointer">
                                        {{ $row->observacao }}
                                    </td>
                                    <td ng-click="openModalForm('{{ route('financeiroEditReceber', ['id' => $row->id]) }}')" class="cursor-pointer">
                                        {{ $row->codigo }}
                                    </td>
                                    <td ng-click="openModalForm('{{ route('financeiroEditReceber', ['id' => $row->id]) }}')" class="cursor-pointer">
                                        {{ $row->nota_fiscal }}
                                    </td>
                                    <td ng-click="openModalForm('{{ route('financeiroEditReceber', ['id' => $row->id]) }}')" class="cursor-pointer">
                                        {{ !is_null($row->formapagamento) ? $row->formapagamento->nome : '' }}
                                    </td>
                                    <td ng-click="openModalForm('{{ route('financeiroEditReceber', ['id' => $row->id]) }}')" class="cursor-pointer">
                                        {{ !is_null($row->conta) ? $row->conta->nome : '' }}
                                    </td>
                                    <td ng-click="openModalForm('{{ route('financeiroEditReceber', ['id' => $row->id]) }}')" class="cursor-pointer">
                                        @if($row->tratamento)
                                            {{ $row->tratamento->created_at }}
                                            <span 
                                                class="m-0 p-2 cursor-pointer"
                                                data-toggle="tooltip" 
                                                data-placement="left"
                                                data-html="true"
                                                data-title="Código: #{{ $row->tratamento->id }}<br>Início: {{ $row->tratamento->created_at }}<hr class='my-3'>Primeira Sessão: {{ timestampToBr($row->data_primeira_sessao) }}<br>Última sessão: {{ timestampToBr($row->data_ultima_sessao) }}" 
                                            >
                                                <i class="fa fa-search"></i>
                                            </span>
                                        @endif
                                    </td>
                                    <td ng-click="openModalForm('{{ route('financeiroEditReceber', ['id' => $row->id]) }}')" class="cursor-pointer">
                                        {{ $row->tipo }}
                                    </td>
                                @else 
                                    <td class="text-center text-gray-600" style="opacity: 0.70;">
                                        {{ $row->emissao }}
                                    </td>
                                    <td class="text-center text-gray-600">
                                        {{ $row->vencimento }}
                                    </td>
                                    <td class="text-center text-gray-600">
                                        {{ $row->pagamento }}
                                    </td>
                                    <td class="text-gray-600 font-bold text-right">
                                        <span 
                                            class="cursor-pointer"
                                            data-toggle="tooltip" 
                                            data-placement="left"
                                            data-html="true"
                                            data-title="Valor: {{ $row->valor }}<br>Descontos/Taxas: {{ $row->desconto_taxa }}<br>Juros/Multa: {{ $row->juros_multa }}<br>Valor Pago: {{ $row->valor_pago }}" 
                                        >
                                            {{ $row->valor_pago }}
                                        </span>
                                    </td>
                                    <td class="text-center text-gray-600">
                                        {{ $row->parcela ? $row->parcela : 1 }}
                                    </td>
                                    <td class="text-gray-600">
                                        @if(!is_null($row->tratamento))
                                            @if(!is_null($row->tratamento->convenio))
                                                {{$row->tratamento->convenio->nome}}
                                            @endif
                                        @endif
                                    </td>
                                    <td class="text-gray-600">
                                        @if(!is_null($row->tratamento))
                                            @if(!is_null($row->tratamento->paciente))
                                                {{ $row->tratamento->paciente->nome }}
                                            @endif
                                        @endif
                                    </td>
                                    <td class="text-gray-600">
                                        {{ $row->observacao }}
                                    </td>
                                    <td class="text-gray-600">
                                        {{ $row->codigo }}
                                    </td>
                                    <td class="text-gray-600">
                                        {{ $row->nota_fiscal }}
                                    </td>
                                    <td class="text-gray-600">
                                        {{ !is_null($row->formapagamento) ? $row->formapagamento->nome : '' }}
                                    </td>
                                    <td class="text-gray-600">
                                        {{ !is_null($row->conta) ? $row->conta->nome : '' }}
                                    </td>
                                    <td class="text-gray-600">
                                        @if($row->tratamento)
                                            {{ $row->tratamento->created_at }}
                                            <span 
                                                class="m-0 p-2 cursor-pointer"
                                                data-toggle="tooltip" 
                                                data-placement="left"
                                                data-html="true"
                                                data-title="Código: #{{ $row->tratamento->id }}<br>Início: {{ $row->tratamento->created_at }}<hr class='my-3'>Primeira Sessão: {{ timestampToBr($row->data_primeira_sessao) }}<br>Última sessão: {{ timestampToBr($row->data_ultima_sessao) }}" 
                                            >
                                                <i class="fa fa-search"></i>
                                            </span>
                                        @endif
                                    </td>
                                    <td class="text-gray-600">
                                        {{ $row->tipo }}
                                    </td>
                                @endif
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <div class="text-xl p-6 cursor-pointer" ng-click="toggleTotais()">
                <div class="text-2xl mb-4">Totais</div>
                <div ng-show="show_totais">
                    <div>Total: <strong>{{valorBr($total_valor)}}</strong></div>
                    <div>Total com Descontos/Taxas: <strong>{{valorBr($total_valor_pago)}}</strong></div>
                </div>
                <i ng-show="!show_totais" class="opacity-75 fa fa-lg fa-eye-slash"></i>
            </div>
        </div>
    </div>
@stop
