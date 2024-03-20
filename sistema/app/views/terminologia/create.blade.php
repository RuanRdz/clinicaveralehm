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
        <li><a href="{{route('terminologiauniformeconfig')}}">Terminologia Uniforme</a></li>
        <li class="active">Cadastro</li>
    </ol>
@stop

@section('content')

    <div class="row">
        <div class="col-xs-16 col-sm-14 col-sm-offset-1 col-md-10 col-md-offset-3 col-lg-8 col-lg-offset-4">

            <form action="{{ $action }}" method="POST">
                {{ Form::token() }}

                <div class="form-theme-default">
                    <div class="form-heading">Terminologia Uniforme</div>
                    <div class="form-body">
                        <!-- fields -->
                        <div class="form-group">
                            <label for="parent_id">Hierarquia</label>
                            {{ Form::select('parent_id', $parents, Session::get('parent_id'), array('class'=>'form-control')) }}
                            <span class="help-block">{{ $errors->first('parent_id') }}</span>
                        </div>

                        <div class="row">
                            <div class="col-xs-3">
                                <div class="form-group">
                                    <label for="code">Código</label>
                                    <input type="text" name="code" value="" class="form-control" id="code">
                                    <span class="help-block">{{ $errors->first('code') }}</span>
                                </div>
                            </div>
                            <div class="col-xs-13">
                                <div class="form-group">
                                    <label for="label" class="text-primary">Nome</label>
                                    <input type="text" name="label" value="" class="form-control" id="label">
                                    <span class="help-block">{{ $errors->first('label') }}</span>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-xs-5">
                                <div class="form-group">
                                    <label for="level">Nível</label>
                                    {{ Form::select('level', $levels, Session::get('level'), array('class'=>'form-control')) }}
                                    <span class="help-block">{{ $errors->first('level') }}</span>
                                </div>
                            </div>
                            <div class="col-xs-5">
                                <div class="form-group">
                                    <label for="is_question">O item é uma pergunta</label>
                                    {{ Form::select('is_question', $is_question, 1, array('class'=>'form-control')) }}
                                    <span class="help-block">{{ $errors->first('is_question') }}</span>
                                </div>
                            </div>
                        </div>
                        <!-- fields -->
                    </div>
                    <div class="form-footer">
                        <div class="col">
                            {{ Former::actions('<a href="'.route('terminologiauniformeconfig').'" class="btn btn-default">Cancelar</a>', Former::submit('Salvar')->class('btn btn-primary'))->class('text-right') }}
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>

@stop
