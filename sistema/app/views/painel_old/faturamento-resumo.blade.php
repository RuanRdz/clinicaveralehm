
<div class="bg-white shadow-md">
    <table class="table">
        @if (!is_null($tratamento->convenio))
            <tr>
                <td class="text-right" style="background:#f4f4f4;">Convênio</td>
                <td colspan="2" style="background:#f0f0f0;">
                    <span style=" font-size: 10px;">
                        <strong>{{ $tratamento->convenio->nome }}</strong>
                        <br />
                        @if ($tratamento->convenio->cidade)
                            {{
                                $tratamento->convenio->cidade->nome.' / '.
                                $tratamento->convenio->cidade->estado_uf
                            }}
                        @endif
                    </span>
                    <br />
                    Dia de Vencimento:
                    @if ($tratamento->convenio->dia_vencimento)
                        <strong>{{ $tratamento->convenio->dia_vencimento }}</strong>
                    @else
                        <strong>Nenhum</strong>
                    @endif
                </td>
            </tr>
            <tr class="hide">
                <td colspan="2" class="text-right" style="background:#f4f4f4;">Valor por Sessão</td>
                <td style="background:#f0f0f0;">{{ $tratamento->convenio->valor }}</td>
            </tr>
        @endif
    
        <tr>
            <td colspan="2" class="text-right" style="background:#f4f4f4;">
                Valor do tratamento
            </td>
            <td style="background:#e3e3e3;">
                {{ $faturamento['total'] }}
            </td>
        </tr>
        <tr>
            <td colspan="2" class="text-right"style="background:#f9f9f9;">
                Total lançado
            </td>
            <td style="background:#f0f0f0;">
                {{ $faturamento['total_lancado'] }}
            </td>
        </tr>
        <tr>
            <td colspan="2" class="text-right"style="background:#f9f9f9;">
                Saldo a lançar
            </td>
            <td style="background:#f0f0f0;">
                {{ $faturamento['saldo_a_lancar'] }}
            </td>
        </tr>
        <tr>
            <td colspan="2" class="text-right" style="background:#f9f9f9;">
                Lançamentos a pagar
            </td>
            <td style="background:#f0f0f0;">
                @if ($faturamento['lancamentos_a_pagar'] == 0)
                    <strong class="text-success">{{ $faturamento['lancamentos_a_pagar'] }}</strong>
                @else
                    <strong class="text-danger">{{ $faturamento['lancamentos_a_pagar'] }}</strong>
                @endif
            </td>
        </tr>
        <tr>
            <td colspan="2" class="text-right"style="background:#f9f9f9;">
                Total pago
            </td>
            <td style="background:#f0f0f0;">
                <strong class="text-success">{{ $faturamento['total_pago'] }}</strong>
            </td>
        </tr>
    </table>
</div>
