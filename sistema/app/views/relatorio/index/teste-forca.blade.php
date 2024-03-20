<table class="report-table">
    <thead>
        <tr>
            <th colspan="10" class="report-table-title">TESTE DE FORÇA MUSCULAR</th>
        </tr>
        <tr>
            <th colspan="3"></th>
            <th colspan="6" class="text-center">Grau</th>
            <th></th>
        </tr>
        <tr>
            <th>Grupo</th>
            <th>Músculo</th>
            <th>Movimento</th>
            <th class="text-center" style="width: 40px;">0</th>
            <th class="text-center" style="width: 40px;">1</th>
            <th class="text-center" style="width: 40px;">2</th>
            <th class="text-center" style="width: 40px;">3</th>
            <th class="text-center" style="width: 40px;">4</th>
            <th class="text-center" style="width: 40px;">5</th>
            <th class="text-center" style="width: 110px;">Data</th>
        </tr>
    </thead>
    <tbody>
        <?php $i = 0;?>
        @foreach ($testeforcatratamentos as $grupo => $movimentos)
            @foreach ($movimentos as $movimento => $musculos)
                <?php $countDados = 1;?>
                @foreach ($musculos as $musculo => $dados)
                    <?php $i++;?>
                    <tr class="{{ ($i % 2) ? 'report-row-even' : 'report-row-odd' }}">
                        <td>{{ $grupo }}</td>
                        <td>{{ $movimento }}</t>
                        <td>{{ $musculo }}</td>
                        <td colspan="7" class="report-no-padding">
                            <table class="report-inner-table">
                                <tbody>
                                    @foreach ($dados as $row)
                                    <tr>
                                        <?php
                                        // $bb = $countDados < count($dados) ? 'border-bottom: 1px solid #ccc;' : '';
                                        $bb = '';
                                        for ($g = 0; $g < 6; $g++) {
                                            echo $g == $row['grau']
                                            ? '<td style="width: 40px;" class="text-center">
                                                 <span style="font-size: 9px !important; color: #505050 !important;"><i class="fa fa-check"></i></span>
                                               </td>'
                                            : '<td style="width: 40px;"></td>';
                                        }
                                        ?>
                                        <td class="text-center" style="width: 109px;">{{ $row['data'] }}</td>
                                    </tr>
                                    <?php $countDados++;?>
                                    @endforeach
                                </tbody>
                            </table>
                        </td>
                    </tr>
                @endforeach
            @endforeach
        @endforeach
    </tbody>
</table>
