@extends('layouts.admin.template')

@section('head')
	@parent
	<title>Sistema</title>
@stop

@section('main-panel-heading')
	@parent
	<ol class="breadcrumb">
        <li>Recursos</li>
		<li>Financeiro</li>
		<li class="active">Fornecedores</li>
	</ol>
@stop

@section('content')
    <div ng-controller="ListRecursos">
        <div class="row mb-3">
            <div class="col-sm-3">
                <button
                    type="button"
                    class="btn btn-primary"
                    ng-click="openModalForm('{{route('fornecedoresCreate')}}')"
                >
                    <i class="fa fa-plus fa-fw"></i> Cadastrar
                </button>
            </div>
            <div class="col-sm-13 text-right">
                <ul class="pagination">
                    <li class="{{ 'number' == $current_char ? 'active' : '' }}">
                        <a href="{{route('fornecedores', ['char' => 'number', 'page' => 1])}}">0 - 9</a>
                    </li>
                    @foreach(range('A', 'Z') as $char)
                        <li class="{{ $char == $current_char ? 'active' : '' }}">
                            <a href="{{route('fornecedores', ['char' => $char, 'page' => 1])}}">{{ $char }}</a>
                        </li>
                    @endforeach
                </ul>
            </div>
        </div>
        <div class="bg-white shadow-md">
            <table class="table table-striped table-hover valign-middle border-0">
                <thead>
                    <tr>
                        <th style="50px;">ID</th>
                        <th>Fornecedor</th>
                        <th>Razão Social</th>
                        <th>CNPJ</th>
                        <th>Inscrição Estadual</th>
                        <th>CPF</th>
                        <th>Telefone</th>
                        <th>Celular</th>
                        <th>E-mail</th>
                        <th>Cidade</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($fornecedores as $row)
                        <tr 
                            ng-click="openModalForm('{{route('fornecedoresEdit', array('id' => $row->id))}}')"
                            class="cursor-pointer"
                        >
                            <td>{{ $row->id }}</td>
                            <td>{{ $row->nome }}</td>
                            <td>{{ $row->razao_social }}</td>
                            <td>{{ $row->cnpj }}</td>
                            <td>{{ $row->inscricao_estadual }}</td>
                            <td>{{ $row->cpf }}</td>
                            <td>{{ $row->telefone }}</td>
                            <td>
                                {{ $row->celular }}
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
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <div class="text-right">
            {{ $fornecedores->appends(Request::except('page'))->links() }}
        </div>
    </div>
@stop
