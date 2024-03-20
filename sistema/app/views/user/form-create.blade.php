@extends('layouts.admin.template')

@section('head')
	@parent
	<title>Sistema</title>
@stop

@section('main-panel-heading')
	@parent
	<ol class="breadcrumb">
		<li><a href="{{route('users')}}">Usuários</a></li>
		<li class="active">Cadastro</li>
	</ol>
@stop

@section('content')
    <div class="row">
        <div class="col-xs-16 col-sm-14 col-sm-offset-1 col-md-10 col-md-offset-3 col-lg-8 col-lg-offset-4">
            <form action="{{$action}}" method="POST">
                {{ Form::token() }}
                <div class="form-theme-default">
                    <div class="form-heading">Cadastro de usuário</div>
                    <div class="form-body">
                
                        <div class="form-group">
                            <label for="create_name">Nome</label>
                            <input type="text" name="create_name" value="" class="form-control" id="create_name">
                            <span class="help-block">{{ $errors->first('create_name') }}</span>
                        </div>
                        <div class="form-group">
                            <label for="create_last_name">Sobrenome</label>
                            <input type="text" name="create_last_name" value="" class="form-control" id="create_last_name">
                            <span class="help-block">{{ $errors->first('create_last_name') }}</span>
                        </div>
                        <div class="row">
                            <div class="col-xs-12">
                                <div class="form-group">
                                    <label for="create_email">E-mail</label>
                                    <input type="text" name="create_email" value="" class="form-control" id="create_email">
                                    <span class="help-block">{{ $errors->first('create_email') }}</span>
                                </div>
                            </div>
                            <div class="col-xs-4">
                                <div class="form-group">
                                    <label for="create_crefito">CREFITO</label>
                                    <input type="text" name="create_crefito" value="" class="form-control" id="create_crefito">
                                    <span class="help-block">{{ $errors->first('create_crefito') }}</span>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-xs-9">
                                <div class="well">
                                    <div class="form-group">
                                        {{ Former::select('create_credential')
                                            ->options($credentials)
                                            ->select(20)
                                            ->class('form-control')
                                            ->label('Credencial de acesso') }}
                                        <span class="help-block">{{ $errors->first('create_credential') }}</span>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xs-7">
                                <div class="form-group">
                                    <label for="create_password">Senha</label>
                                    <input type="password" name="create_password" value="" class="form-control" id="create_password">
                                    <span class="help-block">{{ $errors->first('create_password') }}</span>
                                </div>
                            </div>
                        </div>
        
                    </div>
                    <div class="form-footer">
                        <div class="col text-right">
                            <button type="submit" class="btn btn-primary">Salvar</button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
@stop
