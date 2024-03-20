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
		<li><a href="{{ route('tratamentos') }}">Tratamentos</a></li>
		<li class="active">Tipos de tratamento</li>
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
                        ng-click="openModalForm('{{route('tratamentotiposCreate')}}')"
                    >
                        <i class="fa fa-plus fa-fw"></i> Cadastrar
                    </button>
                </div>
                <div class="bg-white shadow-md">
                    <table class="table table-striped table-hover valign-middle">
                        <thead>
                            <tr>
                                <th style="50px;">ID</th>
                                <th>Tipo de tratamento</th>
                                <th style="width:70px;">Sequência</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($tratamentotipos as $row)
                                <tr 
                                    ng-click="openModalForm('{{route('tratamentotiposEdit', array('id' => $row->id))}}')"
                                    class="cursor-pointer"
                                >    
                                    <td>{{ $row->id }}</td>
                                    <td>{{ $row->nome }}</td>
                                    <td class="text-center">{{ $row->sequencia }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@stop
