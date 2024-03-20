@extends('layouts.admin.template')

@section('head')
    @parent
    <title>Sistema</title>
@stop

@section('main-panel-heading')
    @parent
    <ol class="breadcrumb">
        <li>{{ link_to_route('painel', $treatment->paciente->nome, ['id' => $treatment->paciente->id, 'id2' => $treatment->id]) }}</li>
        <li class="active">Terminologia Uniforme</li>
    </ol>

@stop

@section('content')

    <form action="{{ $action }}" method="POST">
        {{ Form::token() }}

        {{ Form::hidden('tratamento_id', $treatment->id) }}

        <div style="min-width: 800px; overflow-x: scroll;">
            <div class="panel panel-default">
                <div class="panel-heading">
                    @include('protocols.tests.header-form')
                </div>
                <div class="panel-body text-right">
                    <button type="submit" class="btn btn-primary">Salvar</button>
                </div>
                <div class="panel-body">
                    <div class="terminologiaForm">
                        <div class="row">
                            {{ $tree }}
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </form>

@stop
