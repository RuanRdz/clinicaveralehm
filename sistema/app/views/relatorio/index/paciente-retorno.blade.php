<table class="report-table">
    <thead>
        <tr>
            <?php
            /*
            @if(in_array('E', $dadosControle))
            <th style="width:30%">{{ $blocos['E'] }}</th>
            @endif
            */
            ?>
            @if(in_array('E', $dadosControle))
            <th style="width:30%" class="report-table-title">{{ $blocos['E'] }}</th>
            @endif
            @if(in_array('F', $dadosControle))
            <th class="report-table-title">{{ $blocos['F'] }}</th>
            @endif
        </tr>
    </thead>
    <tbody>
        <tr>
            <?php
            /*
            @if(in_array('D', $dadosControle))
            <td style="width:25%">
            <p>{{ $blocos['D'] }}</p>
            @foreach ($opcoes['D'] as $anamnese)
            <?php //$at = $dados[$anamnese->id]?>
            @if ($at->checkbox == 'on')
            <i class="fa fa-check-circle-o"></i>
            @else
            <i class="fa fa-circle-o"></i>
            @endif
            @if ($anamnese->opcao == 'simples')
            {{ $anamnese->nome }}
            @else
            {{ $anamnese->nome }}:
            <u>{{ $at->resposta }}</u>
            @endif
            <br />
            @endforeach
            </td>
            @endif
            */
            ?>
            @if(in_array('E', $dadosControle))
            <td>
                @foreach ($opcoes['E'] as $anamnese)
                <?php $at = $dados[$anamnese->id]?>
                @if ($at->checkbox == 'on')
                <i class="fa fa-check-circle-o"></i>
                @else
                <i class="fa fa-circle-o"></i>
                @endif
                @if ($anamnese->opcao == 'simples')
                {{ $anamnese->nome }}
                @else
                {{ $anamnese->nome }}:
                <u>{{ $at->resposta }}</u>
                @endif
                <br />
                @endforeach
            </td>
            @endif

            @if(in_array('F', $dadosControle))
            <td>
                @foreach ($opcoes['F'] as $anamnese)
                <?php $at = $dados[$anamnese->id]?>
                @if ($at->checkbox == 'on')
                <i class="fa fa-check-circle-o"></i>
                @else
                <i class="fa fa-circle-o"></i>
                @endif
                @if ($anamnese->opcao == 'simples')
                {{ $anamnese->nome }}
                @else
                {{ $anamnese->nome }}:
                <u>{{ $at->resposta }}</u>
                @endif
                <br />
                @endforeach
            </td>
            @endif
        </tr>
    </tbody>
</table>
