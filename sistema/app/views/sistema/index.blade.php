@extends('layouts.admin.template')

@section('head')
	@parent
	<title>Sistema</title>
@stop

@section('main-panel-heading')
	@parent
	<ol class="breadcrumb">
		<li>Sistema</li>
		<li class="active">Configurações</li>
	</ol>
@stop

@section('content')
<div class="row">
    <div class="col-xs-16 col-sm-14 col-sm-offset-1 col-md-10 col-md-offset-3 col-lg-8 col-lg-offset-4">
        {{ Form::open(['route' => 'sistemaUpdate', 'role' => 'form']) }}
            <div class="form-theme-default">
                <div class="form-heading">Informações da Empresa</div>
                <div class="form-body">
                    @foreach ($sistema as $s)
                        <div class="form-group">
                            {{ Form::label($s->id, $s->chave_label) }}
                            {{ Form::text($s->id, $s->descricao, ['class' => 'form-control']) }}
                        </div>
                    @endforeach
                </div>
                <div class="form-footer">
                    <div class="col text-right">
                        {{ Former::actions(Former::submit('Salvar')->class('btn btn-primary')) }}
                    </div>
                </div>
            </div>
        {{ Form::close() }}
    </div>
</div>
@stop
