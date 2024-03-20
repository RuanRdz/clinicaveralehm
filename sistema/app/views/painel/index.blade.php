@extends('layouts.admin.template')

@section('head')
	@parent
	<title>Sistema</title>
@stop

@section('main-panel-heading')
	@parent
	<ol class="breadcrumb text-xl">
		<li><a href="{{ route('agendas') }}"><i class="fa fa-calendar-o"></i> Horários do Dia</a></li>
		<li class="active">Painel</li>
	</ol>
@stop

@section('content')

    @include('painel.paciente-header')

    <!-- Nav tabs -->
    <ul class="nav nav-tabs flex justify-around text-lg text-gray-900 font-bold" role="tablist">
        <li role="presentation" class="flex-fill active">
            <a href="#tab-tratamentos" aria-controls="tab-tratamentos" role="tab" data-toggle="tab">
                <div class="text-center">Tratamentos / Agenda</div>
            </a>
        </li>
        @if($tratamento)
            <li role="presentation" class="flex-fill">
                <a href="#tab-financeiro" aria-controls="tab-financeiro" role="tab" data-toggle="tab">
                    <div class="text-center">Financeiro</div>
                </a>
            </li>
        @else 
            <li role="presentation" class="flex-fill">
                <a href disabled>
                    <div class="text-center">Financeiro</div>
                </a>
            </li>
        @endif
        @if($tratamento)
            <li role="presentation" class="flex-fill">
                <a href="#tab-prontuario" aria-controls="tab-prontuario" role="tab" data-toggle="tab">
                    <div class="text-center">
                        Prontuário 
                        <i id="escrevendo_prontuario" class="fa fa-pencil text-primary hidden"></i>
                    </div>
                </a>
            </li>
        @else
            <li role="presentation" class="flex-fill">
                <a href disabled="disabled">
                    <div class="text-center">Prontuário</div>
                </a>
            </li>
        @endif
        @if($tratamento)
            <li role="presentation" class="flex-fill">
                <a href="#tab-protocolos" aria-controls="tab-protocolos" role="tab" data-toggle="tab">
                    <div class="text-center">Protocolos</div>
                </a>
            </li>
        @else 
            <li role="presentation" class="flex-fill">
                <a href disabled>
                    <div class="text-center">Protocolos</div>
                </a>
            </li>
        @endif
    </ul>

    <!-- Tab panes -->
    <div class="tab-content panel">
        @if($tratamento)
            <div role="tabpanel" class="tab-pane panel-body active" id="tab-tratamentos">
                <div class="py-4">
                    @include('painel.tratamentos')
                </div>
            </div>
            <div role="tabpanel" class="tab-pane panel-body" id="tab-prontuario">
                <div class="py-4">
                    @include('painel.prontuario')
                </div>
            </div>
            <div role="tabpanel" class="tab-pane panel-body" id="tab-protocolos">
                <div class="py-4">
                    @include('painel.protocolos') 
                </div>
            </div>
            <div role="tabpanel" class="tab-pane panel-body" id="tab-financeiro">
                <div class="py-4">
                    @include('painel.faturamento') 
                </div>
            </div>
        @else 
            <div class="panel-body text-center my-5">
                <div class="text-xl text-gray-600 my-8">
                    Nenhum tratamento realizado
                </div>
                <a
                    class="btn btn-primary"
                    href="{{ route('tratamentosCreate', ['id' => $paciente->id]) }}"
                    title="Novo tratamento">
                    <i class="fa fa-plus fa-fw"></i> Novo Tratamento
                </a>
            </div>
        @endif
    </div>
        
	@if($tratamento)
		<!-- Modals -->
		@include('painel.logs')
		<!-- Modals -->
	@endif
	{{ View::make('layouts.admin.print-footer') }}
@stop
