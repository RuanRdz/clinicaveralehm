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
		<li class="active">Gabaritos prontuário</li>
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
                        ng-click="openModalForm('{{route('textosprontuarioCreate')}}')"
                    >
                        <i class="fa fa-plus fa-fw"></i> Cadastrar
                    </button>
                </div>
                <div class="bg-white shadow">
                    <table class="table table-striped table-hover valign-middle border-0">
                        <thead>
                            <tr>
                                <th style="50px;">ID</th>
                                <th>Gabarito</th>
                                <th style="width: 80px">Sequência</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($dados as $row)
                                <tr 
                                    ng-click="openModalForm('{{route('textosprontuarioEdit', array('id' => $row->id))}}')"
                                    class="cursor-pointer"
                                >
                                    <td>{{ $row->id }}</td>
                                    <td>{{ $row->nome }}</td>
                                    <td>{{ $row->ordem }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@stop