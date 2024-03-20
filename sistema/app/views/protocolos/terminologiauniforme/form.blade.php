@extends('layouts.admin.template')

@section('head')
    @parent
    <title>Sistema</title>
@stop

@section('main-panel-heading')
    @parent
    <ol class="breadcrumb">
        <li>{{ link_to_route('painel', $t->paciente->nome, ['id' => $t->paciente->id, 'id2' => $t->id]) }}</li>
        <li class="active">Terminologia Uniforme</li>
    </ol>

@stop

@section('content')

    <form action="{{ $action }}" method="POST">
        {{ Form::token() }}

        <div class="panel panel-default">
            <div class="panel-heading text-center">
                <strong>TERMINOLOGIA UNIFORME</strong>
            </div>
            <div class="panel-body">

                <div class="terminologiaForm">
                    <div class="row">
                        {{ $tree }}
                    </div>
                </div>

            </div>
            <div class="panel-footer text-center">
                <button type="submit" class="btn btn-primary">Salvar</button>
            </div>
        </div>
    </form>

@stop
