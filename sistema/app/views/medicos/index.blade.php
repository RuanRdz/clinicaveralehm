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
		<li class="active">Médicos</li>
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
                            ng-click="openModalForm('{{route('medicosCreate')}}')"
                        >
                            <i class="fa fa-plus fa-fw"></i> Cadastrar
                        </button>
                    </div>
                    <div class="col-sm-8 text-right">
                        {{ $medicos->links() }}
                    </div>
                </div>
                <div class="bg-white shadow-md">
                    <table class="table table-striped table-hover valign-middle border-0">
                        <thead>
                            <tr>
                                <th style="50px;">ID</th>
                                <th>Nome</th>
                                <th>CPF</th>
                                <th>CRM</th>
                                <th>Telefones</th>
                                <th>Endereço</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($medicos as $row)
                                <tr 
                                    ng-click="openModalForm('{{route('medicosEdit', array('id' => $row->id))}}')"
                                    class="cursor-pointer"
                                >    
                                    <td>{{ $row->id }}</td>
                                    <td>{{ $row->nome }}</td>
                                    <td>{{ $row->cpf }}</td>
                                    <td>{{ $row->crm }}</td>
                                    <td>{{ $row->telefone }}</td>
                                    <td>{{ $row->endereco }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="text-right">
                    {{ $medicos->links() }}
                </div>
            </div>
        </div>
    </div>
@stop