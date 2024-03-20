@extends('layouts.admin.template')

@section('head')
	@parent
	<title>Sistema</title>
@stop

@section('main-panel-heading')
	@parent
	<ol class="breadcrumb">
        <li>Recursos</li>
		<li>Clínica</li>
		<li class="active">Convênios</li>
	</ol>
@stop

@section('content')
    <div ng-controller="ListRecursos">
        <div class="row">
            <div class="col-xs-16 col-lg-14 col-lg-offset-1">
                <div class="row mb-3">
                    <div class="col-sm-8">
                        <button
                            type="button"
                            class="btn btn-primary"
                            ng-click="openModalForm('{{route('conveniosCreate')}}')"
                        >
                            <i class="fa fa-plus fa-fw"></i> Cadastrar
                        </button>
                    </div>
                    <div class="col-sm-8 text-right">
                        {{ $convenios->links() }}
                    </div>
                </div>
                <div class="bg-white shadow-md">
                    <table class="table table-striped table-hover valign-middle border-0">
                        <thead>
                            <tr>
                                <th style="50px;">ID</th>
                                <th>Convênio</th>
                                <th>Cidade</th>
                                <th>Tipo</th>
                                <th>Valor</th>
                                <th title="Número de sessões por tratamento">Limite Sessões</th>
                                <th>Dia Vencimento</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($convenios as $row)
                                <tr 
                                    ng-click="openModalForm('{{route('conveniosEdit', array('id' => $row->id))}}')"
                                    class="cursor-pointer"
                                >
                                    <td>{{ $row->id }}</td>
                                    <td>{{ $row->nome }}</td>
                                    <td>
                                        @if ($row->cidade_id)
                                            {{ $row->cidade->nome.' - '. $row->cidade->estado_uf }}
                                        @endif
                                    </td>
                                    <td>{{ $row->conveniotipo->nome }}</td>
                                    <td>{{ $row->valor }}</td>
                                    <td>{{ $row->limite_sessoes }}</td>
                                    <td>{{ $row->dia_vencimento }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="text-right">
                    {{ $convenios->links() }}
                </div>
            </div>
        </div>
    </div>
@stop