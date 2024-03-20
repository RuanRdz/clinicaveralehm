<table class="report-table">
    <thead>
        <tr>
            <th colspan="9" class="report-table-title">TABELA DE FORÇA</th>
        </tr>
        <tr>
            <th></th>
            <th class="text-center" colspan="2">Força de Preensão</th>
            <th class="text-center" colspan="2">Pinça Polpa - Lateral</th>
            <th class="text-center" colspan="2">Pinça trípode</th>
            <th class="text-center" colspan="2">Pinça Polpa - Polpa</th>
        </tr>
        <tr>
            <th class="text-center" style="width:120px">Data</th>
            <th class="text-center">Mão Direita</th>
            <th class="text-center">Mão Esquerda</th>
            <th class="text-center">Mão Direita</th>
            <th class="text-center">Mão Esquerda</th>
            <th class="text-center">Mão Direita</th>
            <th class="text-center">Mão Esquerda</th>
            <th class="text-center">Mão Direita</th>
            <th class="text-center">Mão Esquerda</th>
        </tr>
    </thead>
    <tbody>
        <?php $i = 0;?>
        @foreach ($tabelaforca as $row)
            <?php $i++;?>
            <tr class="{{ ($i % 2) ? 'report-row-even' : 'report-row-odd' }}">
                <td class="text-center">{{ $row->data_sessao }}</td>
                <td class="text-center">{{ $row->f1d }}</td>
                <td class="text-center">{{ $row->f1e }}</td>
                <td class="text-center">{{ $row->f2d }}</td>
                <td class="text-center">{{ $row->f2e }}</td>
                <td class="text-center">{{ $row->f3d }}</td>
                <td class="text-center">{{ $row->f3e }}</td>
                <td class="text-center">{{ $row->f4d }}</td>
                <td class="text-center">{{ $row->f4e }}</td>
            </tr>
        @endforeach
    </tbody>
</table>
