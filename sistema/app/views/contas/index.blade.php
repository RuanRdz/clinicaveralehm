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
		<li class="active">Contas</li>
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
                        ng-click="openModalForm('{{route('contasCreate')}}')"
                    >
                        <i class="fa fa-plus fa-fw"></i> Cadastrar
                    </button>
                </div>
                <div class="bg-white shadow-md">
                    <table class="table table-striped table-hover valign-middle border-0">
                        <thead>
                            <tr>
                                <th style="50px;">ID</th>
                                <th>Conta</th>
                                <th>Banco</th>
                                <th>Agência</th>
                                <th>Nº da Conta</th>
                                <th style="width: 160px;">Saldo Inicial</th>
                                <th style="width: 160px;">Data do Saldo</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($contas as $row)
                                <?php $saldoInicial = $row->loadSaldoInicial();?>
                                <tr 
                                    ng-click="openModalForm('{{route('contasEdit', array('id' => $row->id))}}')"
                                    class="cursor-pointer"
                                >
                                    <td>{{ $row->id }}</td>
                                    <td>{{ $row->nome }}</td>
                                    <td>{{ $row->banco->nome }}</td>
                                    <td>{{ $row->agencia }}</td>
                                    <td>{{ $row->conta }}</td>                                    
                                    @if(!empty($saldoInicial))
                                        <td>{{ $saldoInicial->valor }}</td>
                                        <td>{{ $saldoInicial->emissao }}</td>
                                    @else 
                                        <td class="text-gray-500">indefinido</td>
                                        <td class="text-gray-500">indefinido</td>
                                    @endif
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@stop
