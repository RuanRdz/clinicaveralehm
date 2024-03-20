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
		<li class="active">Atendimentos</li>
	</ol>
@stop

@section('content')

    <div class="no-print">
        {{ Form::open(array('route' => 'agendasControle', 'class' => 'form form-inline', 'role' => 'form')) }}
            <div class="row">
                <div class="col-xs-16 text-center pb-2">
                    <div class="form-group">
                        <div class="input-group">
                            <div class="input-group-addon">De</div>
                            {{ Form::text('data_inicial', timestampToBr($filtro['data_inicial']), ['class' => 'form-control datepicker', 'style' => 'width: 120px;']) }}
                        </div>
                    </div>
                    &nbsp;&nbsp;
                    <div class="form-group">
                        <div class="input-group">
                            <div class="input-group-addon">Até</div>
                            {{ Form::text('data_final', timestampToBr($filtro['data_final']), ['class' => 'form-control datepicker', 'style' => 'width: 120px;']) }}
                        </div>
                    </div>
                    &nbsp;&nbsp;
                    <div class="form-group">
                        <div class="input-group">
                            <div class="input-group-addon">Situação</div>
                            {{ Form::select('agendasituacao_id', $situacoes, $filtro['agendasituacao_id'], ['class' => 'form-control']) }}
                        </div>
                    </div>
                    &nbsp;&nbsp;
                    <div class="form-group">
                        <div class="input-group">
                            <div class="input-group-addon">Sessões</div>
                            {{ Form::select('filtro_sessao', $sessoes, $filtro['filtro_sessao'], ['class' => 'form-control']) }}
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-xs-16 text-center pb-2">
                    @include('workspaces.dropdown-profissional', array('terapeutas' => $terapeutas, 'user_id' => $filtro['terapeuta_id']))
                    &nbsp;&nbsp;
                    <div class="form-group">
                        <div class="input-group">
                            <div class="input-group-addon">Médico</div>
                            {{ Form::select('medico_id', $medicos, $filtro['medico_id'], ['class' => 'form-control']) }}
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-xs-16 text-center pb-2">
                    <div class="form-group">
                        <div class="input-group">
                            <div class="input-group-addon">Tipo de tratamento</div>
                            {{
                            Form::select(
                                'tratamentotipo_id',
                                $tratamentotipos,
                                $filtro['tratamentotipo_id'],
                                ['class' => 'form-control']
                            )
                            }}
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="input-group">
                            <div class="input-group-addon">Convênio</div>
                            {{ Form::select('convenio_id', $convenios, $filtro['convenio_id'], ['class' => 'form-control']) }}
                        </div>
                    </div>
                </div>
                <div class="col-xs-16 text-center pt-3">
                    {{ Form::button('Atendimentos', ['type'  => 'submit', 'name'  => 'genero', 'value' => 'atendimento', 'class' => 'btn btn-primary active' ]) }}
                    {{ Form::button('Bloqueios', ['type'  => 'submit', 'name'  => 'genero', 'value' => 'bloqueio', 'class' => 'btn btn-warning']) }}
                    {{ Form::button('Agendamentos', ['type'  => 'submit', 'name'  => 'genero', 'value' => 'agendamento', 'class' => 'btn btn-info']) }}
                </div>
            </div>
        {{ Form::close() }}
    </div>

    <!-- Nav tabs -->
    <ul class="nav nav-tabs" role="tablist">
        <li role="presentation" class="active">
            <a href="#tab_listagem" aria-controls="tab_listagem" role="tab" data-toggle="tab" class="text-xl">Agenda</a>
        </li>
        <li role="presentation">
            <a href="#tab_sessoes" aria-controls="tab_sessoes" role="tab" data-toggle="tab" class="text-xl">Sessões</a>
        </li>
        <li role="presentation">
            <a href="#tab_medicos" aria-controls="tab_medicos" role="tab" data-toggle="tab" class="text-xl">Médicos</a>
        </li>
        <li role="presentation">
            <a href="#tab_convenios" aria-controls="tab_convenios" role="tab" data-toggle="tab" class="text-xl">Convênios</a>
        </li>
        <li role="presentation">
            <a href="#tab_pacientes" aria-controls="tab_pacientes" role="tab" data-toggle="tab" class="text-xl">Pacientes</a>
        </li>
    </ul>

    <!-- Tab panes -->
    <div class="tab-content panel">
        
        <div role="tabpanel" class="tab-pane active panel-body" id="tab_listagem">
            @if (count($agenda) > 0)
                <?php $valor_sessao_total = 0;?>
                <div class="bg-white shadow-md mt-8">
                    <table class="table table-condensed valign-middle">
                        <thead>
                            <tr>
                                <th class="no-print" style="width:30px;"></th>
                                <th style="width:120px;">Data</th>
                                <th style="width:70px;" title="Hora Inicial">H. Inicial</th>
                                <th style="width:70px;" title="Hora Final">H. Final</th>
                                <th>Paciente</th>
                                <th style="width:60px;">Sessão</th>
                                <th>Situação</th>
                                @if (User::allowedCredentials([10], true))
                                    <th class="text-right">Valor</th>
                                @endif
                                <th>Profissional</th>
                                <th>Médico</th>
                                <th>Convênio</th>
                                <th>Tipo Tratamento</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($agenda as $row)
                                <?php $valor_sessao_total += $row->valor_sessao;?>
                                <tr style="background-color: {{ $row->agendasituacao->bg_color }}">
                                    <td class="no-print">
                                        <div class="btn-group">
                                            <button type="button" class="btn btn-link dropdown-toggle" data-toggle="dropdown">
                                                <i class="fa fa-pencil fa-lg fa-fw text-gray-600"></i>
                                            </button>
                                            <ul class="dropdown-menu" role="menu">
                                                <li>
                                                    <a class="btn-agendar" href="{{ route('agendasEdit', ['id' => $row->id_sessao]) }}">
                                                        <i class="fa fa-pencil fa-fw"></i> Editar
                                                    </a>
                                                </li>
                                                <li class="divider"></li>
                                                <li>
                                                    <a href="{{ route('painel', array('id' => $row->paciente_id, 'id2' => $row['tratamento_id'])) }}">
                                                        <i class="fa fa-share fa-fw"></i> Ir para o painel do paciente
                                                    </a>
                                                </li>
                                            </ul>
                                        </div>
                                    </td>
                                    <td>
                                        {{ diaBr(date('D', strtotime($row->data_sessao))) }},
                                        {{ $row->data_sessao }}
                                    </td>
                                    <td>{{ $row->inicio }}</td>
                                    <td>{{ $row->fim }}</td>
                                    <td>
                                        @if($row->tratamento->paciente)
                                            {{ $row->tratamento->paciente->nome }}
                                        @endif
                                    </td>
                                    <td>{{ $row->sessao }} / {{ $row->tratamento->sessoes }}</td>
                                    <td>
                                        @if($row->agendasituacao)
                                            {{ $row->agendasituacao->nome_sumario }}
                                        @endif
                                    </td>
                                    @if (User::allowedCredentials([10], true))
                                        <td class="text-right font-bold">
                                            {{number_format($row->valor_sessao, 2, ',', '.')}}
                                        </td>
                                    @endif
                                    <td>
                                        @if($row->tratamento->terapeuta)
                                            {{ $row->tratamento->terapeuta->name }}
                                        @endif
                                    </td>
                                    <td>
                                        @if ($row->tratamento->medico)
                                            {{ $row->tratamento->medico->nome }}
                                        @else
                                            <i class="fa fa-exclamation-triangle text-red-500"></i>
                                        @endif
                                    </td>
                                    <td>
                                        @if ($row->tratamento->convenio)
                                            {{ $row->tratamento->convenio->nome }}
                                        @else
                                            <i class="fa fa-exclamation-triangle text-red-500"></i>
                                        @endif
                                    </td>
                                    <td>
                                        @if($row->tratamento->tratamentotipo)
                                            {{ $row->tratamento->tratamentotipo->nome }}
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                        @if (User::allowedCredentials([10], true))
                            <tfoot>
                                <tr>
                                    <td colspan="7"></td>
                                    <td class="text-right font-bold">
                                        {{number_format($valor_sessao_total, 2, ',', '.')}}
                                    </td>
                                </tr>
                            </tfoot>
                        @endif
                    </table>
                </div>
            @else
                <div class="text-center text-gray-600 text-xl my-12">
                    Nenhum registro encontrado para o filtro selecionado
                </div>
            @endif
        </div>
        
        <div role="tabpanel" class="tab-pane panel-body" id="tab_sessoes">
            <div class="row">
                <div class="col-sm-12 col-md-10 col-md-offset-3 col-lg-8 col-lg-offset-4">
                    <div 
                        id="chart_agenda_sessoes" 
                        data-grafico='{{$graficoSessoes}}'>
                    </div>
                </div>
            </div>
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h4>Contagem de sessões por situação</h4>
                </div>
                <div class="panel-body">
                    <table class="table table-hover" style="font-size: 15px;">
                        <tr>
                            <th class="py-2">Situação</th>
                            <th class="py-2 text-right">Contagem Sessões</th>
                        </tr>
                        @foreach($listaSessoes as $row)
                            <tr>
                                <td>{{ $row['situacao'] }}</td>
                                <td class="text-right">{{ $row['contagem'] }}</td>
                            </tr>
                        @endforeach
                    </table>
                </div>
            </div>
        </div>
        
        <div role="tabpanel" class="tab-pane panel-body" id="tab_medicos">
            <div 
                id="chart_agenda_lista_medicos" 
                data-grafico='{{$listaMedicos['grafico']}}'>
            </div>
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h4>Sessões atendidas por médico</h4>
                </div>
                <div class="panel-body">
                    <table class="table table-hover" style="font-size: 15px;">
                        <tr>
                            <th class="py-2">Médico</th>
                            <th class="py-2 text-right">Sessões Concluídas</th>
                        </tr>
                        @foreach($listaMedicos['listagem'] as $row)
                            <tr>
                                <td>{{ $row['nome'] }}</td>
                                <td class="text-right">{{ $row['sessoes'] }}</td>
                            </tr>
                        @endforeach
                    </table>
                </div>
            </div>
        </div>
        
        <div role="tabpanel" class="tab-pane panel-body" id="tab_convenios">
            <div 
                id="chart_agenda_lista_convenios" 
                data-grafico='{{$listaConvenios['grafico']}}'>
            </div>
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h4>Sessões atendidas por convênio</h4>
                </div>
                <div class="panel-body">
                    <table class="table table-hover" style="font-size: 15px;">
                        <tr>
                            <th class="py-2">Convênio</th>
                            <th class="py-2 text-right" style="width: 15%">Sessões Concluídas</th>
                            @if(User::allowedCredentials(array(10), true))
                                <th class="py-2 text-right" style="width: 15%">Total</th>
                            @endif
                        </tr>
                        @foreach($listaConvenios['listagem'] as $row)
                            <tr>
                                <td>{{ $row['nome'] }}</td>
                                <td class="text-right">{{ $row['sessoes'] }}</td>
                                @if(User::allowedCredentials(array(10), true))
                                    <td class="text-right">{{ $row['subtotal'] }}</td>
                                @endif
                            </tr>
                        @endforeach
                        @if(User::allowedCredentials(array(10), true))
                            <tr>
                                <td></td>
                                <td></td>
                                <td class="text-right">
                                    <strong>{{$listaConvenios['valor_total']}}</strong>
                                </td>
                            </tr>
                        @endif
                    </table>
                </div>
            </div>
        </div>

        <div role="tabpanel" class="tab-pane panel-body" id="tab_pacientes">
            <div class="panel panel-default">
                <div class="panel-heading">
                        <h4>Pacientes atendidos no período</h4>
                </div>
                <div class="panel-body">
                    <table class="table table-hover" style="font-size: 15px;">
                        @foreach($listaPacientes as $row)
                            <tr>
                                <td>{{ $row }}</td>
                            </tr>
                        @endforeach
                    </table>
                </div>
            </div>
        </div>
    
    </div>
@stop
