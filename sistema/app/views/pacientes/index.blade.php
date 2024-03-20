@extends('layouts.admin.template')

@section('head')
	@parent
	<title>Sistema</title>
@stop

@section('main-panel-heading')
	@parent
	<ol class="breadcrumb">
		<li class="active">Pacientes</li>
	</ol>
@stop

@section('content')
    @include('pacientes.filtro-listagem')
    <div class="row mb-3 no-print">
        <div class="col-sm-4">
            <a class="btn btn-primary" href="{{ route('pacientesCreate') }}">
                <i class="fa fa-plus fa-fw"></i> Paciente
            </a>
            <button
                type="button"
                class="btn btn-warning mr-4"
                data-toggle="modal" 
                data-target="#modal_filtro_listagem_pacientes"
            >
                <i class="fa fa-filter"></i> Filtro
            </button>
            <span class="text-gray-700 text-lg h-12 inline-block">
                {{ $pacientes->getTotal() }} Pacientes
            </span>
        </div>
        <div class="col-sm-12 text-right">
            <ul class="pagination">
                <li class="{{ 'number' == $current_char ? 'active' : '' }}">
                    <a href="{{route('pacientes', ['char' => 'number', 'page' => 1])}}">0 - 9</a>
                </li>
                @foreach(range('A', 'Z') as $char)
                    <li class="{{ $char == $current_char ? 'active' : '' }}">
                        <a href="{{route('pacientes', ['char' => $char, 'page' => 1])}}">{{ $char }}</a>
                    </li>
                @endforeach
            </ul>
        </div>
    </div>

    @if (count($pacientes) > 0)
        <div class="bg-white shadow-md">
            <table class="table table-condensed table-striped table-hover valign-middle">
                <thead>
                    <tr>
                        <th style="width: 50px;"></th>
                        <th style="50px;">ID</th>
                        <th>Paciente</th>
                        <th>Telefone</th>
                        <th>Celular</th>
                        <th>E-mail</th>
                        <th>Cidade</th>
                        <th>Empresa</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($pacientes as $row)
                        <tr>
                            <td>
                                <div class="btn-group">
                                    <button type="button" class="btn btn-link dropdown-toggle" data-toggle="dropdown">
                                        <i class="fa fa-pencil fa-lg text-gray-600"></i>
                                    </button>
                                    <ul class="dropdown-menu" role="menu">
                                        <li>
                                            <a href="{{ route('painel', array('id' => $row->id)) }}">
                                                <i class="fa fa-stethoscope fa-fw"></i> Painel
                                            </a>
                                        </li>
                                        <li>
                                            <a href="{{ route('pacientesShow', array('id' => $row->id)) }}">
                                                <i class="fa fa-file-text-o fa-fw"></i> Visualizar
                                            </a>
                                        </li>
                                        <li>
                                            <a href="{{ route('pacientesEdit', array('id' => $row->id)) }}">
                                                <i class="fa fa-pencil fa-fw"></i> Editar
                                            </a>
                                        </li>
                                        <li>
                                            <a href="{{ route('pacientesDestroy', array('id' => $row->id)) }}" class="confirm-destroy">
                                                <i class="fa fa-trash fa-fw"></i> Excluir
                                            </a>
                                        </li>
                                    </ul>
                                </div>
                            </td>
                            <td>{{ $row->id }}</td>
                            <td>{{ $row->nome }}</td>
                            <td>{{ $row->telefone }}</td>
                            <td>
                                {{ $row->fone_celular }}
                                @if (!empty($row->operadora_celular))
                                    &nbsp;({{ $row->operadora_celular }})
                                @endif
                            </td>
                            <td>{{ $row->email }}</td>
                            <td>
                                @if ($row->cidade)
                                    {{ $row->cidade->nome.' - '. $row->cidade->estado_uf }}
                                @endif
                            </td>
                            <td>{{ $row->empresa }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <div class="text-right">
            {{ $pacientes->appends(Request::except('page'))->links() }}
        </div>
    @else 
        <div class="text-center text-gray-600 text-xl my-12">
            Nenhum registro encontrado para o filtro selecionado
        </div>
    @endif
@stop
