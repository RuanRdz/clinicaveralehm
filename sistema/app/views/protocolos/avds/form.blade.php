@extends('layouts.admin.template')

@section('head')
	@parent
	<title>Sistema</title>
@stop

@section('main-panel-heading')
	@parent
	<ol class="breadcrumb">
		<li>{{ link_to_route('painel', $t->paciente->nome, ['id' => $t->paciente->id, 'id2' => $t->id]) }}</li>
	</ol>
@stop

@section('content')

    {{
    Form::open([
        'route' => 'avdsUpdate',
        'role' => 'form',
        'class' => 'form form-inline form-anamnesetratamentos'
    ])
    }}
    {{ Form::hidden('tratamento_id', $t->id) }}

	<div class="panel panel-default">
		<div class="panel-heading">
			{{ $blocos['C'] }}
		</div>
		<div class="panel-body">
			<table class="table table-bordered table-striped table-hover table-condensed">
		        <tr>
		            <th style="width:20%">Grupo</th>
		            <th style="width:35%">Ação</th>
		            <th class="text-center" style="width:7%">Avaliado</th>
		            <th>Resultado</th>
		        </tr>
		        @foreach ($avds as $anamnese)
		            <?php $at = $dados[$anamnese->id]?>
		            <tr>
		                <td>{{ $opcoesAtividade[$anamnese->opcao_atividade] }}</td>
		                <td>
		                    <span class="no-print" style="margin: 0; padding: 0; line-height: 1; color: #999; font-family: monospace;">{{ $anamnese->id }}</span>
		                    {{ $anamnese->nome }}
		                </td>
		                <td class="text-center">
		                    <div class="checkbox">
		                        {{ Form::hidden($at->id.'[avaliado]', 'off') }}
		                        <label>
		                            {{
		                            Form::checkbox(
		                                $at->id.'[avaliado]',
		                                $at->avaliado,
		                                $at->avaliado == 'on' ? true : false
		                            )
		                            }}
		                        </label>
		                    </div>
		                </td>
		                <td>
		                    {{ Form::select($at->id.'[opcao]', $opcoesDificuldade, $at->opcao) }}
		                </td>
		            </tr>
		        @endforeach
		    </table>
		</div>
		<div class="panel-footer">
            {{ Form::submit('Salvar', ['class' => 'btn btn-primary']) }}
        </div>
	</div>

	{{ Former::close() }}

@stop
