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
		<li class="active">Segmentos</li>
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
                            ng-click="openModalForm('{{route('membrosCreate')}}')"
                        >
                            <i class="fa fa-plus fa-fw"></i> Cadastrar
                        </button>
                    </div>
                    <div class="col-sm-8 text-right">
                        {{ $membros->links() }}
                    </div>
                </div>
                <div class="bg-white shadow-md">
                    <table class="table table-striped table-hover valign-middle border-0">
                        <thead>
                            <tr>
                                <th style="50px;">ID</th>
                                <th>Segmento</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($membros as $row)
                                <tr 
                                    ng-click="openModalForm('{{route('membrosEdit', array('id' => $row->id))}}')"
                                    class="cursor-pointer"
                                >
                                    <td>{{ $row->id }}</td>
                                    <td>{{ $row->nome }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="text-right">
                    {{ $membros->links() }}
                </div>
            </div>
        </div>
    </div>
@stop