
@if (User::allowedCredentials([10, 30], true))
    <div ng-controller="ListRecursos">
        <div class="row">
            <div class="col-md-6">
                @include('painel.faturamento-resumo')
            </div>
            <div class="col-md-10">
                @if(valorFloat($faturamento['total_lancado']) < valorFloat($faturamento['total']))
                    @if($faturamento['total'] > 0)
                        <div class="mb-8">
                            <button 
                                type="button"
                                class="btn btn-primary"
                                ng-click="openModalForm('{{ route('financeiroCreateReceber', ['id' => $tratamento->id]) }}')"
                            >
                                <i class="fa fa-plus fa-fw"></i> Recebimento
                            </button>
                            <button
                                type="button"
                                class="btn btn-default ml-4"
                                ng-click="openModalForm('{{ route('financeiroCreateReceberParcelado', ['id' => $tratamento->id]) }}')"
                            >
                                <span class="text-gray-600">
                                    <i class="fa fa-plus fa-fw"></i> Recebimento Parcelado
                                </span>
                            </button>
                        </div>
                    @endif
                @elseif(valorFloat($faturamento['total']) == 0)
                    <div class="alert alert-warning" role="alert">Não há valores para lançamento.</div>
                @elseif(valorFloat($faturamento['total_lancado']) == valorFloat($faturamento['total']))
                    <div class="alert alert-success" role="alert">Lançamento finalizado.</div>
                @else
                    <div class="alert alert-danger" role="alert">A soma de lançamentos excedeu o valor do tratamento.</div>
                @endif
                @if($tratamento->tratamentosituacao_id == 1)
                    <div class="mb-8">
                        <button
                            type="button"
                            class="btn btn-default"
                            ng-click="openModalForm('{{ route('tratamentosFormAlterarValores', ['id' => $tratamento->id]) }}')"
                        >
                            <span class="text-black">
                                <i class="fa fa-pencil fa-fw"></i> Alterar valores do tratamento
                            </span>
                        </button>
                    </div>
                @endif
            </div>
        </div>
        @if(count($lancamentosPaciente))
            <div class="bg-white shadow-md mt-10">
                <table class="table table-condensed table-bordered valign-middle">
                    <thead>
                        <tr>
                            <th class="w-12">ID</th>
                            <th style="width:25px;"></th>
                            <th style="width:60px;">Lote</th>
                            <th style="width:90px;" class="text-gray-500">Competência<br>Emissão</th>
                            <th style="width:100px;">Vencimento <i class="fa fa-sort-asc"></i>Previsão</th>
                            <th style="width:90px;">Pagamento<br>Concluído</th>
                            <th style="width:80px;" class="text-right">Valor</th>
                            <th style="width:80px;" class="text-right">Valor Pago</th>
                            <th style="width:70px;" class="text-center">Parcela</th>
                            <th>Código/Guia</th>
                            <th>Nº Nota Fiscal</th>
                            <th style="width:150px;">Conta</th>
                            <th style="width:150px;">Forma de Pagamento</th>
                            <th style="width:150px;">Documento</th>
                            <th>Observação</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($lancamentosPaciente as $row)
                            @if ($row->pagamento)
                                <tr class="hover:underline bg-success">
                            @elseif (!$row->pagamento && (brDateToDatabase($row->vencimento) < date('Y-m-d')))
                                <tr class="hover:underline bg-danger">
                            @else
                                <tr class="hover:underline">
                            @endif
                                <td class="text-gray-500">#{{ $row->id }}</td>
                                <td class="text-center">
                                    @if(!$row->tipo_lancamento && !$row->lote)
                                        <button 
                                            type="button"
                                            class="p-1 btn btn-link"
                                            ng-click="openModalForm('{{ route('financeiroEditReceber', ['id' => $row->id]) }}')"
                                        >
                                            <i class="fa fa-pencil fa-lg fa-fw text-gray-600"></i>
                                        </button>
                                    @else 
                                        <button 
                                            type="button"
                                            class="p-1 btn btn-link"
                                            title="Este registro já foi lançado na Movimentação"
                                            disabled
                                        >
                                            <i class="fa fa-pencil fa-lg fa-fw text-gray-400"></i>
                                        </button>
                                    @endif 
                                </td>
                                <td>
                                    @if($row->lote)
                                        <span title="Vinculado ao Lote: {{ $row->lote }}">{{ $row->lote }}</span>
                                    @elseif($row->tipo_lancamento)
                                        <span title="Lançado individualmente">( i )</span>
                                    @endif
                                </td>
                                <td style="opacity: 0.70;">{{ $row->emissao }}</td>
                                <td>{{ $row->vencimento }}</td>
                                <td>{{ $row->pagamento }}</td>
                                <td class="text-right">{{ $row->valor }}</td>
                                <td class="text-right">{{ $row->valor_pago }}</td>
                                <td class="text-center">{{ $row->parcela ? $row->parcela : 1 }}</td>
                                <td>{{ $row->codigo }}</td>
                                <td>{{ $row->nota_fiscal }}</td>
                                <td>{{ $row->conta ? $row->conta->nome : '' }}</td>
                                <td>{{ $row->formapagamento ? $row->formapagamento->nome : '' }}</td>
                                <td>{{ $row->documento ? $row->documento->nome : '' }}</td>
                                <td>{{ $row->observacao }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @endif
    </div>
@else
    <div>Credencial de acesso não autorizada</div>
@endif

