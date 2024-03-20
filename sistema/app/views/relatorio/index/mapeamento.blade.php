<table class="report-table">
    <thead>
        <tr>
            @if(count($blocos['A']) > 0)
                <th colspan="3" class="report-table-title">{{ $blocos['A'] }}</th>
            @endif
        </tr>
    </thead>
    <tbody>
        @if(count($blocos['A']) > 0)
            @foreach ($opcoes['A'] as $row)
                <?php $at = $dados[$row->id];?>
                <tr>
                    <td style="width: 30px; padding-top: 2px !important; padding-bottom: 2px !important; text-align: center;">
                        @if ($at->checkbox == 'on')
                            <i class="fa fa-check-circle-o"></i>
                        @else
                            <i class="fa fa-circle-o"></i>
                        @endif
                    </td>
                    <td style="padding-top: 2px !important; padding-bottom: 2px !important;">
                        {{ $row->nome }}
                    </td>
                </tr>
            @endforeach
            <tr>
                <td
                    colspan="2"
                    style="padding-top: 0 !important; padding-bottom: 1px !important; text-align: center;">
                    <img style="width: 180px !important;" src="{{ URL::asset('img/escala-kapandji.png') }}"/>
                </td>
            </tr>
        @endif
    </tbody>
</table>
