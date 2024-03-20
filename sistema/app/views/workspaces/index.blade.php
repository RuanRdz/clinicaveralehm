@extends('layouts.admin.template')

@section('head')
	@parent
	<title>Sistema</title>
@stop

@section('main-panel-heading')
	@parent
	<ol class="breadcrumb">
		<li>Recursos</li>
		<li class="active">Áreas de trabalho</li>
	</ol>
@stop

@section('content')
    <div ng-controller="ListRecursos">
        <div class="row">
            <div class="col-xs-16 col-lg-14 col-lg-offset-1">
                <div class="mb-3 text-right">
                    <button
                        type="button"
                        class="btn btn-primary"
                        ng-click="openModalForm('{{route('workspacesCreate')}}')"
                    >
                        <i class="fa fa-plus fa-fw"></i> Cadastrar
                    </button>
                </div>
                <div class="bg-white shadow">
                    <table class="table table-striped table-hover valign-middle border-0">
                        <thead>
                            <tr>
                                <th>Áreas de trabalho</th>
                                <th>Ativo</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($workspaces as $row)
                                <tr 
                                    ng-click="openModalForm('{{route('workspacesEdit', array('id' => $row->id))}}')"
                                    class="cursor-pointer"
                                >
                                    <td>{{ $row->nome }}</td>
                                    <td>{{ Workspace::$opcoesVisivel[$row->visivel] }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@stop