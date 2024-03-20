<table class="report-table">
    <thead>
        <tr>
            @if(count($opcoes['B']) > 0)
                <th colspan="3" class="report-table-title">{{ $blocos['B'] }}</th>
            @endif
        </tr>
    </thead>
    <tbody>
        @if(count($opcoes['B']) > 0)

            @foreach ($opcoes['B'] as $row)
                <?php $at = $dados[$row->id];?>
                @if ($at->checkbox == 'on')
                    <tr>
                        <td style="width: 20px; padding-top: 0 !important; padding-bottom: 1px !important;">
                            <i class="fa fa-check-circle-o"></i>
                        </td>
                        <td style="padding-top: 0 !important; padding-bottom: 1px !important;">
                            {{ $row->nome }}
                        </td>
                        <td style="width: 65%; padding-top: 0 !important; padding-bottom: 1px !important;">
                            {{ $at->resposta }}
                        </td>
                    </tr>
                @endif
            @endforeach

        @endif
    </tbody>
</table>
