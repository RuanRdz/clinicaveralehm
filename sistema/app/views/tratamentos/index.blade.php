@extends('layouts.admin.template')

@section('head')
	@parent
	<title>Sistema</title>
@stop

@section('main-panel-heading')
	@parent
	<ol class="breadcrumb">
		<li>Clínica</li>
		<li class="active">Tratamentos</li>
	</ol>
@stop

@section('content')
    @include('tratamentos.filtro-listagem')
    <div class="row mb-3 no-print">
        <div class="col-sm-8">
            <button
                type="button"
                class="btn btn-warning mr-4"
                data-toggle="modal" 
                data-target="#modal_filtro_listagem_tratamentos"
            >
                <i class="fa fa-filter"></i> Filtro
            </button>
            <span class="text-gray-700 text-lg h-12 inline-block">
                {{ $tratamentos->getTotal() }} Tratamentos
            </span>
        </div>
        <div class="col-sm-8 text-right">
            {{ $tratamentos->links() }}
        </div>
    </div>

    @if (count($tratamentos) > 0)
        <div class="bg-white shadow-md">
            <table class="table table-condensed table-hover valign-middle">
                <thead>
                    <tr>
                        <th style="width:30px;"></th>
                        <th>Tratamento</th>
                        <th>Tipo</th>
                        <th>Paciente</th>
                        <th>Sessões</th>
                        <th style="width: 100px;">Data da lesão</th>
                        <th>Lesão</th>
                        <th>Convênio</th>
                        <th>Médico</th>
                        <th>Situação</th>
                        <th>Profissional</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($tratamentos as $row)
                        <tr style="background-color: {{ $row->tratamentosituacao->bg_color }}">
                            <td>
                                <div class="btn-group">
                                    <button type="button" class="btn btn-link dropdown-toggle" data-toggle="dropdown">
                                        <i class="fa fa-pencil fa-lg fa-fw text-gray-600"></i>
                                    </button>
                                    <ul class="dropdown-menu" role="menu">
                                        <li>
                                            <a href="{{ route('tratamentosEdit', array('id' => $row->id)) }}">
                                                <i class="fa fa-pencil fa-fw"></i> Editar Tratamento
                                            </a>
                                        </li>
                                        <li class="divider"></li>
                                        <li>
                                            <a href="{{ route('painel', array('id' => $row->paciente->id, 'id2' => $row->id)) }}">
                                                <i class="fa fa-share fa-fw"></i> Ir para o painel do paciente 
                                            </a>
                                        </li>
                                    </ul>
                                </div>
                            </td>
        
                            <td>{{ $row->created_at }}</td>
                            <td>{{ !is_null($row->tratamentotipo) ? $row->tratamentotipo->nome : '' }}</td>
                            <td>{{ !is_null($row->paciente) ? $row->paciente->nome : ''}}</td>
                            <td>{{ $row->sessoes }}</td>
                            <td>{{ $row->data_lesao }}</td>
                            <td>{{ !is_null($row->lesao) ? $row->lesao->nome : '' }}</td>
                            <td>{{ !is_null($row->convenio) ? $row->convenio->nome : '' }}</td>
                            <td>{{ !is_null($row->medico) ? $row->medico->nome : '' }}</td>
                            <td>{{ !is_null($row->tratamentosituacao) ? $row->tratamentosituacao->nome : '' }}</td>
                            <td>{{ !is_null($row->terapeuta) ? $row->terapeuta->name : '' }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <div class="text-right">
            {{ $tratamentos->links() }}
        </div>
    @else 
        <div class="text-center text-gray-600 text-xl my-12">
            Nenhum registro encontrado para o filtro selecionado
        </div>
    @endif

@stop