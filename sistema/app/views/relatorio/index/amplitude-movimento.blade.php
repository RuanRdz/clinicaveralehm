<table class="report-table">
    <thead>
        <tr>
            <th colspan="7" class="report-table-title">AMPLITUDE DE MOVIMENTO</th>
        </tr>
        <tr>
            <th>Articulação</th>
            <th>Movimento</th>
            <th style="width: 90px;" class="text-center">Lado</thclass>
            <th style="width: 140px" class="text-center">Graus movimento</thstyle>
            <th style="width: 110px;" class="text-center">Ativo</th>
            <th style="width: 110px;" class="text-center">Passivo</th>
            <th style="width: 110px;" class="text-center">Data</th>
        </tr>
    </thead>
    <tbody>
        <?php $i = 0;?>
        @foreach ($amplitudetratamentos as $articulacao => $movimentos)
            @foreach ($movimentos as $movimento => $lados)
                @foreach ($lados as $lado => $parametros)
                    @foreach ($parametros as $parametro => $dados)
                        <?php $i++;?>
                        <tr class="{{ ($i % 2) ? 'report-row-even' : 'report-row-odd' }}">
                            <td>{{ $articulacao }}</td>
                            <td>{{ $movimento }}</td>
                            <td class="text-center">{{ $lado }}</td>
                            <td class="text-center">{{ $parametro }}</td>
                            <td colspan="3" class="report-no-padding">
                                <table class="report-inner-table">
                                    <tbody>
                                        @foreach ($dados as $row)
                                            <tr>
                                                <td style="width: 33%;" class="text-center">{{ $row['ativo'] }}</td>
                                                <td style="width: 33%;" class="text-center">{{ $row['passivo'] }}</td>
                                                <td style="width: 33%;" class="text-center">{{ $row['data'] }}</td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </td>
                        </tr>
                    @endforeach
                @endforeach
            @endforeach
        @endforeach
    </tbody>
</table>
