@extends('layouts.admin.template')

@section('head')
	@parent
	<title>Sistema</title>
@stop

@section('main-panel-heading')
	@parent
	<ol class="breadcrumb">
		<li class="active">Usuários</li>
	</ol>
@stop

@section('content')

    @if (Session::has('temp_password'))
        <div class="alert alert-danger font-normal text-2xl text-center py-8">
            Nova Senha {{ Session::get('temp_password_name') }}: <strong>{{ Session::get('temp_password') }}</strong>
        </div>
    @endif

    <div ng-controller="ListRecursos">
        <div class="row">
            <div class="col-xs-16 col-lg-14 col-lg-offset-1">
                <div class="mb-3">
                    <a
                        href="{{route('userCreate')}}"
                        class="btn btn-primary"
                    >
                        <i class="fa fa-plus fa-fw"></i> Cadastrar
                    </a>
                </div>
                <div class="bg-white shadow">
                    <table class="table table-striped table-hover valign-middle border-0">
                        <thead>
                            <tr>
                                <th>Nome</th>
                                <th>E-mail</th>
                                <th>Credencial de acesso</th>
                                <th>CREFITO</th>
                                <th style="width: 100px"></th>
                                <th style="width: 120px"></th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($data as $row)
                                <tr>
                                    <td class="font-bold">
                                        {{ $row->fullName }}
                                    </td>
                                    <td>
                                        {{ $row->email }}
                                    </td>
                                    <td>
                                        {{ $credentials[$row->credential] }}
                                    </td>
                                    <td>
                                        {{ $row->crefito }}
                                    </td>
                                    <td>
                                        <button type="button" class="btn btn-primary btn-sm" ng-click="linkTableRow('{{route('userEdit', array('id' => $row->id))}}')">
                                            Editar
                                        </button>
                                    </td>
                                    <td>
                                        <a class="btn btn-warning btn-sm" href="{{route('userRegeneratePassword', array('id' => $row->id))}}">Gerar Senha</a>
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