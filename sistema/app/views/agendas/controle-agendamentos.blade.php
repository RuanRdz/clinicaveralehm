@extends('layouts.admin.template')

@section('head')
	@parent
	<title>Sistema</title>
@stop

@section('main-panel-heading')
	@parent
	<ol class="breadcrumb">
		<li>Clínica</li>
		<li>Agenda</li>
		<li class="active">Agendamentos</li>
	</ol>
@stop

@section('content')

    {{Form::open(array('route' => 'agendasControle', 'class' => 'form form-inline', 'role' => 'form')) }}
    <div class="row">
        <div class="col-xs-16 text-center">
            <div class="form-group">
                <div class="input-group">
                    <div class="input-group-addon">De</div>
                    {{Form::text('data_inicial', timestampToBr($filtro['data_inicial']),
                        [
                            'class' => 'form-control datepicker',
                            'style' => 'width: 120px;'
                        ]
                    )}}
                </div>
            </div>
            <div class="form-group">
                <div class="input-group">
                    <div class="input-group-addon">Até</div>
                    {{Form::text('data_final', timestampToBr($filtro['data_final']),
                        [
                            'class' => 'form-control datepicker',
                            'style' => 'width: 120px;'
                        ]
                    )
                    }}
                </div>
            </div>
            <span class="mx-8">
                @include('workspaces.dropdown-profissional', array('terapeutas' => $terapeutas, 'user_id' => $filtro['terapeuta_id']))
            </span>
        </div>
        <div class="col-xs-16 text-center pt-3">
            {{ Form::button('Atendimentos', ['type'  => 'submit', 'name'  => 'genero', 'value' => 'atendimento', 'class' => 'btn btn-primary' ]) }}
            {{ Form::button('Bloqueios', ['type'  => 'submit', 'name'  => 'genero', 'value' => 'bloqueio', 'class' => 'btn btn-warning']) }}
            {{ Form::button('Agendamentos', ['type'  => 'submit', 'name'  => 'genero', 'value' => 'agendamento', 'class' => 'btn btn-info active']) }}
        </div>
    </div>
    {{ Form::close() }}

    @if(count($agenda) > 0)
        <div class="bg-white shadow-md mt-8">
            <table class="table table-condensed valign-middle">
                <thead>
                    <tr>
                        <th style="width:120px;">Data</th>
                        <th style="width:80px;">Horário</th>
                        <th>Nome</th>
                        <th>Telefone</th>
                        <th>Doença</th>
                        <th>Convênio</th>
                        <th>Médico</th>
                        <th>Observação</th>
                        <th style="width:150px;">Profissional</th>
                        <th style="width:150px;" title="Usuário logado que cadastrou o agendamento">Usuário</th>
                        <th style="width:150px;" title="Indicação manual de quem cadastrou o agendamento">Cadastrado por</th>
                        <th style="width:20px;"></th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($agenda as $row)
                        <tr>
                            <td>
                                {{ diaBr(date('D', strtotime($row->data_sessao))) }},
                                {{ $row->data_sessao }}
                            </td>
                            <td>{{ $row->inicio }}</td>
                            <td>{{ $row->nome_agendamento }}</td>
                            <td>{{ $row->telefone_agendamento }}</td>
                            <td>{{ $row->doenca_agendamento }}</td>
                            <td>{{ $row->convenio_agendamento }}</td>
                            <td>{{ $row->medico_agendamento }}</td>
                            <td>{{ $row->observacao_agendamento }}</td>
                            <td>
                                @if($row->terapeutaagendamento)
                                    {{ $row->terapeutaagendamento->name }}
                                @endif
                            </td>
                            <td>
                                @if($row->createdBy)
                                    {{ $row->createdBy->fullName }}
                                @endif
                            </td>
                            <td>{{ $row->autor }}</td>
                            <td>
                                <a class="confirm-destroy" href="{{ route('agendasDestroyAgendamento', array('id' => $row->id)) }}">
                                    <i class="fa fa-trash"></i>
                                </a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @else
        <div class="text-center text-gray-600 text-xl my-12">
            Nenhum registro encontrado para o filtro selecionado
        </div>
    @endif
@stop
