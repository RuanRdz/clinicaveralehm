@extends('layouts.admin.template')

@section('head')
	@parent
	<title>Sistema</title>
@stop

@section('main-panel-heading')
	@parent
	<ol class="breadcrumb">
        <li><a href="{{route('users')}}">Usuários</a></li>
		<li class="active">Perfil</li>
	</ol>
@stop

@section('content')
    <div class="row">
        <div class="col-xs-16 col-sm-14 col-sm-offset-1 col-md-10 col-md-offset-3 col-lg-8 col-lg-offset-4">
            <form action="{{$action}}" method="POST" enctype="multipart/form-data">
                {{ Form::token() }}
                <div class="form-theme-default">
                    <div class="form-heading">Perfil Usuário</div>
                    <div class="form-body">
                        <!-- form -->
                        <div class="form-group">
                            <label for="edit_name">Nome</label>
                            <input type="text" name="edit_name" value="{{ $data->name }}" class="form-control" id="edit_name">
                            <span class="help-block">{{ $errors->first('edit_name') }}</span>
                        </div>
                        <div class="form-group">
                            <label for="edit_last_name">Sobrenome</label>
                            <input type="text" name="edit_last_name" value="{{ $data->last_name }}" class="form-control" id="edit_last_name">
                            <span class="help-block">{{ $errors->first('edit_last_name') }}</span>
                        </div>
                        <div class="row">
                            <div class="col-xs-12">
                                <div class="form-group">
                                    <label for="edit_email">E-mail</label>
                                    <input type="text" name="edit_email" value="{{ $data->email }}" class="form-control" id="edit_email">
                                    <span class="help-block">{{ $errors->first('edit_email') }}</span>
                                </div>
                            </div>
                            <div class="col-xs-4">
                                <div class="form-group">
                                    <label for="edit_crefito">CREFITO</label>
                                    <input type="text" name="edit_crefito" value="{{ $data->crefito }}" class="form-control" id="edit_crefito">
                                    <span class="help-block">{{ $errors->first('edit_crefito') }}</span>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="row">
                                <div class="col-xs-9">
                                    <div class="well">
                                        @if (User::allowedCredentials([10], true))
                                            <div class="form-group">
                                                {{ Former::select('edit_credential')
                                                    ->options($credentials)
                                                    ->select($data->credential)
                                                    ->class('form-control')
                                                    ->label('Credencial de acesso') }}
                                                <span class="help-block">{{ $errors->first('edit_credential') }}</span>
                                            </div>
                                        @else
                                            Acesso: <strong>{{ $credentials[$data->credential] }}</strong>
                                        @endif
                                    </div>
                                </div>
                                <div class="col-xs-7">
                                    <label for="edit_password">Alterar Senha</label>
                                    <div class="text-danger">Deixar em branco se não deseja alterar</div>
                                    <input type="password" name="edit_password" value="" class="form-control" id="edit_password">
                                    <span class="help-block">{{ $errors->first('edit_password') }}</span>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-xs-8">
                                <div class="form-group">
                                    <label>Upload Imagem Assinatura</label>
                                    <input type="file" name="assinatura" accept="image/*;capture=camera" />
                                    @if ($data->getUrlAssinaturaAttribute())
                                        <div class="mt-5">
                                            <a class="confirm-destroy" href="{{ route('userDestroyAssinatura', array('id' => $data->id)) }}">
                                                <i class="fa fa-trash"></i> Remover assinatura atual
                                            </a>
                                        </div>
                                    @endif
                                </div>
                            </div>
                            <div class="col-xs-8">
                                <div class="px-2" style="border: 2px dashed #ccc;">
                                    @if ($data->getUrlAssinaturaAttribute())
                                        <img src="{{$data->getUrlAssinaturaAttribute()}}" class="inline" style="width: 100%;">
                                    @else
                                        <div>SEM ASSINATURA</div>
                                    @endif
                                </div>
                            </div>
                        </div>
                        <!-- form -->
                    </div>
                    <div class="form-footer">
                        <div class="col">
                            @if (!$data->isAdmin)
                                <a class="confirm-destroy" href="{{ route('userDestroy', array('id' => $data->id)) }}">
                                    <i class="fa fa-trash"></i> Excluir Usuário
                                </a>
                            @endif
                        </div>
                        <div class="col text-right">
                            <button type="submit" class="btn btn-primary">Salvar</button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
@stop
