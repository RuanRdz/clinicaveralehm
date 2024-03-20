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
		<li class="active">Centro de custo</li>
	</ol>
@stop

@section('content')
    <div ng-controller="ListRecursos">
        <div class="row">
            <div class="col-xs-16 col-lg-14 col-lg-offset-1">
                <div class="mb-3">
                    <button
                        type="button"
                        class="btn btn-primary"
                        ng-click="openModalForm('{{route('tipodespesaCreate')}}')"
                    >
                        <i class="fa fa-plus fa-fw"></i> Cadastrar
                    </button>
                </div>
                <div class="bg-white shadow">
                    <table class="table table-striped table-hover valign-middle border-0">
                        <thead>
                            <tr>
                                <th style="50px;">ID</th>
                                <th>Centro de custo</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($tipodespesa as $row)
                                <tr 
                                    ng-click="openModalForm('{{route('tipodespesaEdit', array('id' => $row->id))}}')"
                                    class="cursor-pointer"
                                >
                                    <td>{{ $row->id }}</td>
                                    <td>{{ $row->nome }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@stop