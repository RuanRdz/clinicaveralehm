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
        <li class="active">Parâmetros de atividade</li>
    </ol>
@stop

@section('content')
    <div class="row">
        <div class="col-xs-16 col-lg-14 col-lg-offset-1">
            <div class="row">
                <div class="col-sm-16 col-md-4">
                    @include('atividades-config.menu')
                </div>
                <div class="col-sm-16 col-md-11 col-md-offset-1">
                    <!-- empty -->
                </div>
            </div>
        </div>
    </div>
@stop
