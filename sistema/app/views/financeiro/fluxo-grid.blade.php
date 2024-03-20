
<table class="table-fluxo-de-caixa table table-condensed table-bordered valign-middle">
    <thead>
        <tr class="bg-gray-200 border-b-8">
            <th class="text-lg" style="height: 50px;">
                {{ $dados['header']['ano'] }}
            </th>
            @foreach($dados['header']['meses_nome'] as $mes)
                <th class="text-right text-lg" style="width: 65px;">{{ $mes }}</th>
            @endforeach
            <!-- <th class="text-right text-lg" style="width: 65px;">Total</th> -->
        </tr>
    </thead>
    <tbody>
        @foreach($dados['body'] as $item)
            <tr>
                <td rowspan="3" class="border-b-4 border-gray-400 font-bold">
                    {{$item['nome']}}
                </td>
                <td colspan="12" style="height: 100px; padding: 0 0 0 67px;">
                    <div id="chart_{{$recurso}}_{{$item['id']}}"></div>
                </td>
                <!-- <td></td> -->
            </tr>
            <tr>
                @foreach($item['entrada']['valores'] as $valor)
                    <td class="text-right bg-success">
                        @if($valor > 0)
                            {{ $valor }}
                        @else 
                            <span class="text-gray-400">0</span>
                        @endif
                    </td>
                @endforeach
                <?php /*
                <td class="text-right font-bold bg-success">
                    @if($item['entrada']['total'] > 0)
                        {{ $item['entrada']['total'] }}
                    @else 
                        <span class="text-gray-400">0</span>
                    @endif
                </td>
                */?>
            </tr>
            <tr class="border-b-4 border-gray-400">
                @foreach($item['saida']['valores'] as $valor)
                    <td class="text-right bg-danger">
                        @if($valor > 0)
                            {{ $valor }}
                        @else 
                            <span class="text-gray-400">0</span>
                        @endif
                    </td>
                @endforeach
                <?php /*
                <td class="text-right font-bold bg-danger">
                    @if($item['entrada']['total'] > 0)
                        {{ $item['saida']['total'] }}
                    @else 
                        <span class="text-gray-400">0</span>
                    @endif
                </td>
                */?>
            </tr>
        @endforeach
    </tbody>
</table>
