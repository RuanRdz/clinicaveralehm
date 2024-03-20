
<?php 
$hasData = false;
foreach ($opcoes['B'] as $row) {
    $at = $dados[$row->id];
    if ($at->checkbox == 'on') {
        $hasData = true;
        break;
    }
}
?>

@if($hasData)
	<div class="js-report-content">
		@include('tratamentos.report.page-control')
        <div class="report">
            <table>
                <thead class="title">
                    <tr>
                        <th class="bg-gray" colspan="3">
                            {{ $blocos['B'] }}
                        </th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($opcoes['B'] as $row)
                        <?php $at = $dados[$row->id];?>
                        @if ($at->checkbox == 'on')
                            <tr>
                                <td style="width: 20px;">
                                    <i class="fa fa-check-circle-o"></i>
                                </td>
                                <td>
                                    {{ $row->nome }}
                                </td>
                                <td style="width: 65%;">
                                    {{ $at->resposta }}
                                </td>
                            </tr>
                        @endif
                    @endforeach
                </tbody>
            </table>
        </div>
	</div>
@endif
