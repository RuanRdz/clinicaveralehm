
<div class="row">
    <div class="col-md-8">
        <div class="text-xl">
            Lote: <span class="font-bold">{{ $financeiro->id }}</span>
        </div>
        <div class="text-xl mb-4">
            Valor: <span class="font-bold">{{ $financeiro->valor }}</span>
        </div>
    </div>
    <div class="col-md-8">
        <div class="form-group">
            <input 
                type="text" 
                name="filter_profissional"
                value=""
                id="js-filter-lote-profissional"
                class="form-control input-lg shadow-md"
                placeholder="Filtrar Profissional" 
            >
        </div>
    </div>
</div>

<div class="bg-white shadow-md">
    <table class="table table-condensed table-bordered valign-middle">
        <thead>
            <th class="w-12">ID</th>
            <th style="width:150px;">Código</th>
            <th style="width:100px;" class="bg-gray-200">Competência<br>Emissão</th>
            <th style="width:100px;" class="bg-gray-200">Vencimento<br>Previsão</th>
            <th style="width:100px;" class="bg-gray-200">Pagamento<br>Concluído</th>
            <th style="width:70px;" class="bg-gray-200 text-right">Valor</th>
            <th style="width:80px;" class="bg-gray-200 text-right">Valor Pago</th>
            <th style="width:130px;">Convênio</th>
            <th style="width:130px;">Profissional</th>
            <th>Paciente</th>
            <th>Observação</th>
            <th>Conta</th>
        </thead>
        <tbody id="js-filter-lote-profissional_id">
            @foreach($itens as $row)
                @if ($row->pagamento)
                    <tr class="hover:underline bg-success">
                @elseif (!$row->pagamento && (brDateToDatabase($row->vencimento) < date('Y-m-d')))
                    <tr class="hover:underline bg-danger">
                @else
                    <tr class="hover:underline">
                @endif
                    <td class="text-gray-500">
                        #{{ $row->id }}
                    </td>
                    <td>
                        {{ $row->codigo }}
                    </td>
                    <td>
                        {{ $row->emissao }}
                    </td>
                    <td class="font-bold">
                        {{ $row->vencimento }}
                    </td>
                    <td class="font-bold">
                        {{ $row->pagamento }}
                    </td>
                    <td class="font-bold text-right">
                        {{ $row->valor }}
                    </td>
                    <td class="font-bold text-right">
                        {{ $row->valor_pago }}
                    </td>
                    <td class="text-sm">
                        @if($row->tratamento)
                            @if($row->tratamento->convenio)
                                {{$row->tratamento->convenio->nome}}
                            @endif
                        @endif
                    </td>
                    <td class="text-sm">
                        @if($row->tratamento)
                            @if($row->tratamento->terapeuta)
                                {{$row->tratamento->terapeuta->full_name}}
                            @endif
                        @endif
                    </td>
                    <td class="text-sm">
                        @if($row->tratamento)
                            @if($row->tratamento->paciente)
                                {{ $row->tratamento->paciente->nome }}
                            @endif
                        @endif
                    </td>
                    <td class="text-sm">
                        {{ $row->observacao }}
                    </td>
                    <td class="text-sm">
                        {{ !is_null($row->conta) ? $row->conta->nome : '' }}
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>