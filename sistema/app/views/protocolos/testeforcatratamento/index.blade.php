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

    <div class="panel panel-default">
        <div class="panel-heading">
            TESTE DE FORÇA MUSCULAR
        </div>
        <div class="panel-body">
            <table class="table table-condensed table-bordered table-striped" style="border:none">
                <tr>
                    <td style="width:30px">
                        <a class="btn btn-primary btn-xs" href="{{ route('testeforcatratamentosCreate', ['id' => $t->id]) }}">
                            <i class="fa fa-plus fa-fw"></i>
                        </a>
                    </td>
                    <td style="width:120px">Data</td>
                    <td>Movimento</td>
                    <td>Músculos</td>
                    <td>Grupo</td>
                    <td class="text-center" style="width:50px"><strong>Grau</strong></td>
                </tr>
                @foreach ($testeforcatratamentos as $row)
                    @if ($row->tratamento_id == $t->id)
                        <tr>
                            <td>
                                <div class="btn-group">
                                    <button type="button" class="btn btn-default btn-xs dropdown-toggle" data-toggle="dropdown">
                                        <i class="fa fa-gear fa-fw"></i>
                                    </button>
                                    <ul class="dropdown-menu" role="menu">
                                        <li>
                                            <a href="{{ route('testeforcatratamentosEdit', array('id' => $row->id)) }}">
                                                <i class="fa fa-pencil fa-fw"></i> Editar
                                            </a>
                                        </li>
                                        <li>
                                            <a class="confirm-destroy" href="{{ route('testeforcatratamentosDestroy', array('id' => $row->id)) }}">
                                                <i class="fa fa-trash fa-fw"></i> Excluir
                                            </a>
                                        </li>
                                    </ul>
                                </div>
                            </td>
                            <td>{{ $row->data_sessao }}</td>
                            <td>{{ $row->testeforca->nome }}</td>
                            <td>{{ $row->testeforca->descricao }}</td>
                            <td>{{ $tfCategorias[$row->testeforca->categoria] }}</td>
                            <td class="text-center">{{ $row->grau }}</td>
                        </tr>
                    @else
                        <tr>
                            <td style="color: #707070;"></td>
                            <td style="color: #707070;">{{ $row->data_sessao }}</td>
                            <td style="color: #707070;">{{ $row->testeforca->nome }}</td>
                            <td style="color: #707070;">{{ $row->testeforca->descricao }}</td>
                            <td style="color: #707070;">{{ $tfCategorias[$row->testeforca->categoria] }}</td>
                            <td class="text-center" style="color: #707070;">{{ $row->grau }}</td>
                        </tr>
                    @endif
                @endforeach
            </table>
        </div>
    </div>

@stop
