

<?php 
$array = array();
$array['E'] = array(
    'title' => $blocos['E'],
    'data' => array()
);
$array['F'] = array(
    'title' => $blocos['F'],
    'data' => array()
);
foreach ($opcoes['E'] as $anamnese) {
    $at = $dados[$anamnese->id];
    if ($at->checkbox == 'on') {
        $text = '<i class="fa fa-check-circle-o"></i> ';
        $anamnese->opcao == 'simples'
            ? $text.= $anamnese->nome
            : $text.= $anamnese->nome.': <u>'.$at->resposta.'</u>';
        $text.= '<br />';
        $array['E']['data'][] = $text;
    }
}
foreach ($opcoes['F'] as $anamnese) {
    $at = $dados[$anamnese->id];
    if ($at->checkbox == 'on') {
        $text = '<i class="fa fa-check-circle-o"></i> ';
        $anamnese->opcao == 'simples'
            ? $text.= $anamnese->nome
            : $text.= $anamnese->nome.': <u>'.$at->resposta.'</u>';
        $text.= '<br />';
        $array['F']['data'][] = $text;
    }
}
?>

@if(count($array['E']['data']) > 0 || count($array['F']['data']) > 0)

	<div class="js-report-content">
		@include('tratamentos.report.page-control')
		<p class="only-print">Paciente: {{ $patient_name }}</p>
	</div>

    <div class="report">
        <table>
            <thead class="title">
                <tr>
                    @if(count($array['E']['data']) > 0)
                        <th style="width: 48%;">{{$array['E']['title']}}</th>
                    @endif
                    @if(count($array['F']['data']) > 0)
                        <th style="width: 48%;">{{$array['F']['title']}}</th>
                    @endif
                </tr>
            </thead>
            <tbody>
                <tr>
                    @if(count($array['E']['data']) > 0)
                        <td>
                            @foreach($array['E']['data'] as $key => $text)
                                {{$text}}
                            @endforeach
                        </td>
                    @endif
                    @if(count($array['F']['data']) > 0)
                        <td>
                            @foreach($array['F']['data'] as $key => $text)
                                {{$text}}
                            @endforeach
                        </td>
                    @endif
                </tr>
            </tbody>
        </table>
    </div>
@endif
