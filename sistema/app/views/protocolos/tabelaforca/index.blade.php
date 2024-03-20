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
            TABELA DE FORÇA - JAMAR
        </div>
        <div class="panel-body">
            <table class="table table-condensed table-bordered table-striped" style="border:none">
                <tr>
                    <td colspan="2" style="border:none"></td>
                    <td class="text-center" colspan="2">Força de Preensão</td>
                    <td class="text-center" colspan="2">Pinça Polpa - Lateral</td>
                    <td class="text-center" colspan="2">Pinça trípode</td>
                    <td class="text-center" colspan="2">Pinça Polpa - Polpa</td>
                </tr>
                <tr>
                    <td style="width:30px">
                        <a class="btn btn-primary btn-xs" href="{{ route('tabelaforcaCreate', ['id' => $t->id]) }}">
                            <i class="fa fa-plus fa-fw"></i>
                        </a>
                    </td>
                    <td style="width:120px">Data</td>
                    <td class="text-center">Mão Direita</td>
                    <td class="text-center">Mão Esquerda</td>
                    <td class="text-center">Mão Direita</td>
                    <td class="text-center">Mão Esquerda</td>
                    <td class="text-center">Mão Direita</td>
                    <td class="text-center">Mão Esquerda</td>
                    <td class="text-center">Mão Direita</td>
                    <td class="text-center">Mão Esquerda</td>
                </tr>
                @foreach ($tabelaforca as $row)
                    @if ($row->tratamento_id == $t->id)
                        <tr>
                            <td>
                                <div class="btn-group">
                                    <button type="button" class="btn btn-default btn-xs dropdown-toggle" data-toggle="dropdown">
                                        <i class="fa fa-gear fa-fw"></i>
                                    </button>
                                    <ul class="dropdown-menu" role="menu">
                                        <li>
                                            <a href="{{ route('tabelaforcaEdit', array('id' => $row->id)) }}">
                                                <i class="fa fa-pencil fa-fw"></i> Editar
                                            </a>
                                        </li>
                                        <li>
                                            <a class="confirm-destroy" href="{{ route('tabelaforcaDestroy', array('id' => $row->id)) }}">
                                                <i class="fa fa-trash fa-fw"></i> Excluir
                                            </a>
                                        </li>
                                    </ul>
                                </div>
                            </td>
                            <td>{{ $row->data_sessao }}</td>
                            <td class="text-center">{{ $row->f1d }}</td>
                            <td class="text-center">{{ $row->f1e }}</td>
                            <td class="text-center">{{ $row->f2d }}</td>
                            <td class="text-center">{{ $row->f2e }}</td>
                            <td class="text-center">{{ $row->f3d }}</td>
                            <td class="text-center">{{ $row->f3e }}</td>
                            <td class="text-center">{{ $row->f4d }}</td>
                            <td class="text-center">{{ $row->f4e }}</td>
                        </tr>
                    @else
                        <tr>
                            <td style="color: #707070;"></td>
                            <td style="color: #707070;">{{ $row->data_sessao }}</td>
                            <td class="text-center" style="color: #707070;">{{ $row->f1d }}</td>
                            <td class="text-center" style="color: #707070;">{{ $row->f1e }}</td>
                            <td class="text-center" style="color: #707070;">{{ $row->f2d }}</td>
                            <td class="text-center" style="color: #707070;">{{ $row->f2e }}</td>
                            <td class="text-center" style="color: #707070;">{{ $row->f3d }}</td>
                            <td class="text-center" style="color: #707070;">{{ $row->f3e }}</td>
                            <td class="text-center" style="color: #707070;">{{ $row->f4d }}</td>
                            <td class="text-center" style="color: #707070;">{{ $row->f4e }}</td>
                        </tr>
                    @endif
                @endforeach
            </table>
        </div>
    </div>

@stop
