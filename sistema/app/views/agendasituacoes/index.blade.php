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
		<li><a href="{{ route('agendasControle') }}">Agenda</a></li>
		<li class="active">Situações agenda</li>
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
                        ng-click="openModalForm('{{route('agendasituacoesCreate')}}')"
                    >
                        <i class="fa fa-plus fa-fw"></i> Cadastrar
                    </button>
                </div>
                <div class="bg-white shadow-md">
                    <table class="table valign-middle border-0">
                        <thead>
                            <tr>
                                <th style="50px;">ID</th>
                                <th>Situação Agenda</th>
                                <th>Nome para exibição nas Guias</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($agendasituacoes as $row)
                                <tr 
                                    ng-click="openModalForm('{{route('agendasituacoesEdit', array('id' => $row->id))}}')"
                                    class="cursor-pointer"
                                    style="background-color: {{ $row->bg_color }}"
                                >    
                                    <td>{{ $row->id }}</td>
                                    <td>{{ $row->nome }}</td>
                                    <td>{{ $row->nome_sumario }}</td>
                                    <td class="text-gray-400">
                                        @if ($row->uso_sistema)
                                            <i class="fa fa-lock fa-fw"></i>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@stop