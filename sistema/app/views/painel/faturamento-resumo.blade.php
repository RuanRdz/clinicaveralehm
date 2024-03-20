
<table class="table table-bordered">
    @if ($tratamento->convenio)
        <tr>
            <td class="text-right bg-gray-100">Convênio</td>
            <td class="bg-gray-200">
                <span>
                    <span class="font-bold">
                        {{ $tratamento->convenio->nome }}
                    </span>
                    <br>
                    @if ($tratamento->convenio->cidade)
                        {{
                            $tratamento->convenio->cidade->nome.' / '.
                            $tratamento->convenio->cidade->estado_uf
                        }}
                    @endif
                </span>
                <br>
                Dia de Vencimento:
                @if ($tratamento->convenio->dia_vencimento)
                    <strong>{{ $tratamento->convenio->dia_vencimento }}</strong>
                @else
                    <strong>Indefinido</strong>
                @endif
            </td>
        </tr>
        <tr style="display: none;"><!-- desabilitado -->
            <td class="text-right text-gray-100">Valor por Sessão</td>
            <td class=" text-gray-200">{{ $tratamento->convenio->valor }}</td>
        </tr>
    @endif
    <tr>
        <td class="text-right bg-gray-100">
            Valor da sessão
        </td>
        <td class="bg-gray-200">
            {{ $faturamento['valor_sessao'] }}
        </td>
    </tr>
    <tr>
        <td class="text-right bg-gray-100">
            Valor do tratamento
        </td>
        <td class="bg-gray-200">
            <strong>{{ $faturamento['total'] }}</strong>
        </td>
    </tr>
    <tr>
        <td class="text-right bg-gray-100">
            Total lançado
        </td>
        <td class="bg-gray-200">
            {{ $faturamento['total_lancado'] }}
        </td>
    </tr>
    <tr>
        <td class="text-right bg-gray-100">
            À lançar
        </td>
        <td class="bg-gray-200">
            <strong class="text-orange-500">{{ $faturamento['saldo_a_lancar'] }}</strong>
        </td>
    </tr>
    <tr>
        <td class="text-right bg-gray-100">
            À pagar
        </td>
        <td class="bg-gray-200">
            @if ($faturamento['lancamentos_a_pagar'] == 0)
                <strong class="text-green-600">{{ $faturamento['lancamentos_a_pagar'] }}</strong>
            @else
                <strong class="text-red-600">{{ $faturamento['lancamentos_a_pagar'] }}</strong>
            @endif
        </td>
    </tr>
    <tr>
        <td class="text-right bg-gray-100">
            Total pago
        </td>
        <td class="bg-gray-200">
            <strong class="text-green-600">{{ $faturamento['total_pago'] }}</strong>
        </td>
    </tr>
</table>
