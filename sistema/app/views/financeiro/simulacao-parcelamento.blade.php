<div class="bg-white shadow-md">
    <table class="table table-condensed table-bordered valign-middle">
        <thead>
            <tr>
                <th style="text-align: center;">Parcela</th>
                <th style="text-align: center;">Vencimento</th>
                <th style="text-align: right;">Valor</th>
            </tr>
        </thead>
        <tbody>
            @foreach($parcelamento['parcelas'] as $k => $row)
                <tr>
                    <td style="text-align: center;">{{ $row['parcela'] }}</td>
                    <td style="text-align: center;">{{ $row['vencimento'] }}</td>
                    <td style="text-align: right;">{{ $row['valor'] }}</td>
                </tr>
            @endforeach
        </tbody>
        <tfoot>
            <tr>
                <th colspan="2" style="text-align: right;">
                    Total
                </th>
                <th style="text-align: right;">
                    {{ $parcelamento['total'] }}
                </th>
            </tr>
        </tfoot>
    </table>
</div>
