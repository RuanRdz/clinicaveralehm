@extends('layouts.admin.template')

@section('head')
	@parent
	<title>Sistema</title>
@stop

@section('main-panel-heading')
	@parent
	<ol class="breadcrumb">
		<li>Financeiro</li>
		<li class="active">Fluxo de Caixa</li>
	</ol>
@stop

@section('content')

<div
    ng-controller="FinanceiroFluxoController"
    ng-init="init('{{htmlspecialchars(json_encode($dados), ENT_QUOTES, 'UTF-8')}}')"
>
    <div class="row">
        <div class="col-md-3 pr-8">
            <!-- Nav tabs -->
            <ul class="nav nav-pills nav-stacked" role="tablist">
                <li role="presentation" class="block active"><a href="#centrocusto" aria-controls="centrocusto" role="tab" data-toggle="tab">Centro de custos</a></li>
                <li role="presentation" class="block"><a href="#formapagamento" aria-controls="formapagamento" role="tab" data-toggle="tab">Formas de pagamento</a></li>
                <li role="presentation" class="block"><a href="#tipodespesa" aria-controls="tipodespesa" role="tab" data-toggle="tab">Tipos de despesa</a></li>
                <li role="presentation" class="block"><a href="#documento" aria-controls="documento" role="tab" data-toggle="tab">Documento</a></li>
            </ul>
        </div>
        <div class="col-md-13">
            <!-- Tab panes -->
            <div class="tab-content">
                <div role="tabpanel" class="tab-pane active" id="centrocusto">
                    @include('financeiro.fluxo-grid', ['recurso' => 'centrocusto', 'dados' => $dados['centrocusto']])
                </div>
                <div role="tabpanel" class="tab-pane" id="formapagamento">
                    @include('financeiro.fluxo-grid', ['recurso' => 'formapagamento', 'dados' => $dados['formapagamento']])
                </div>
                <div role="tabpanel" class="tab-pane" id="tipodespesa">
                    @include('financeiro.fluxo-grid', ['recurso' => 'tipodespesa', 'dados' => $dados['tipodespesa']])
                </div>
                <div role="tabpanel" class="tab-pane" id="documento">
                    @include('financeiro.fluxo-grid', ['recurso' => 'documento', 'dados' => $dados['documento']])
                </div>
            </div>
        </div>
    </div>
</div>

@stop
