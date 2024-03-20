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
        'route' => 'mapeamentosensorialUpdate',
        'role' => 'form',
        'class' => 'form form-inline form-anamnesetratamentos'
    ])
    }}
    {{ Form::hidden('tratamento_id', $t->id) }}

    <div class="panel panel-default">
        <div class="panel-heading">
            {{ $blocos['A'] }}
        </div>
        <div class="panel-body">
            @foreach ($mapeamentoSensorial as $anamnese)
                @include('relatorio.edit.b-e-f')
            @endforeach
        </div>
        <div class="panel-footer">
            {{ Form::submit('Salvar', ['class' => 'btn btn-primary']) }}
        </div>
    </div>

	{{ Former::close() }}

@stop
