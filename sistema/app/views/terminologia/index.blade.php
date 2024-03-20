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
        <li class="active">Terminologia Uniforme</li>
    </ol>
@stop

@section('content')

    @if(Auth::user()->id == 1)
        <div class="row no-print">
            <div class="col-xs-16">
                <div class="well">
                    <a 
                        href="{{ route('terminologiauniformeconfigCreate') }}" 
                        class="btn btn-primary"
                    >
                        <i class="fa fa-plus fa-fw"></i> Cadastrar
                    </a>
                </div>
            </div>
        </div>
    @endif

    <div class="terminologiaForm">
        <p class="text-center text-xl text-gray-500 mb-10">
            <strong>Terminologia Uniforme</strong>
        </p>
        <div class="row">
            {{ $tree }}
        </div>
    </div>

@stop
