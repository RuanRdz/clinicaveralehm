@extends('layouts.admin.template')

@section('head')
	@parent
	<title>Sistema</title>
@stop

@section('main-panel-heading')
	@parent
	<ol class="breadcrumb">
		<li>Financeiro</li>
		<li class="active">Saldo Geral</li>
	</ol>
@stop

@section('content')
    <div class="container">

        <div class="row mb-4 no-print">
            <div class="col-sm-4 text-right">
                <?php /*
                <a href="{{ route('financeiroSaldoExcel') }}" class="btn btn-default">
                    <i class="fa fa-file-excel-o"></i> Exportar
                </a>
                */ ?>
            </div>
        </div>

        <div class="row">
            <div class="col-md-4 col-lg-3 lg:pr-8">
                <ul class="nav nav-pills nav-stacked" role="tablist">
                    <li role="presentation" class="block active mb-6">
                        <a href="#conta_geral" aria-controls="conta_geral" role="tab" data-toggle="tab" class="font-bold">GERAL</a>
                    </li>
                    @foreach($contas as $conta)
                        <li role="presentation" class="block">
                            <a href="#conta_{{$conta->id}}" aria-controls="conta_{{$conta->id}}" role="tab" data-toggle="tab">{{$conta->nome}}</a>
                        </li>
                    @endforeach
                </ul>
                <div class="my-20">
                    <a href="{{ route('financeiroProcessarSaldo') }}" id="btnFinanceiroProcessarSaldo" class="btn btn-default">
                        <span class="text-red-600"><i class="fa fa-cog"></i> Processar Saldo</span>
                    </a>
                </div>
            </div>
            <div class="col-md-8 col-lg-10 lg:px-12">
                <div class="tab-content">
                    <div role="tabpanel" class="tab-pane active" id="conta_geral">
                        <div class="mb-4 bg-white shadow-md">
                            <div class="text-xl font-bold p-4">
                                GERAL
                            </div>
                            <table class="table table-condensed table-bordered table-hover valign-middle">
                                <thead>
                                    <tr>
                                        <th class="bg-gray-200" style="width: 50%;">
                                            <span class="lg:px-32">Período</span>
                                        </th>
                                        <th class="bg-gray-200 text-right" style="width: 50%;">
                                            <span class="lg:px-32">Saldo</span>
                                        </th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($dados['geral'] as $row)
                                    <tr>
                                        <td>
                                            <span class="lg:px-32">{{ $row['periodo'] }}</span>
                                        </td>
                                        <td class="text-right">
                                            <span class="lg:px-32">{{ valorBr($row['saldo']) }}</span>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                    @foreach($dados['contas'] as $id => $item)
                        <div role="tabpanel" class="tab-pane" id="conta_{{$id}}">
                            <div class="mb-4 bg-white shadow-md">
                                <div class="text-xl p-4 bg-gray-100">
                                    {{ $item['nome'] }}
                                </div>
                                <table class="table table-condensed table-bordered table-hover valign-middle">
                                    <thead>
                                        <tr>
                                            <th class="bg-gray-200" style="width: 50%;">
                                                <span class="lg:px-32">Período</span>
                                            </th>
                                            <th class="bg-gray-200 text-right" style="width: 50%;">
                                                <span class="lg:px-32">Saldo</span>
                                            </th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($item['dados'] as $row)
                                        <tr>
                                            <td class="">
                                                <span class="lg:px-32">{{ $row['periodo'] }}</span>
                                            </td>
                                            <td class="text-right">
                                                <span class="lg:px-32">{{ valorBr($row['saldo']) }}</span>
                                            </td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
            <div class="col-md-4 col-lg-3">
                <div class="form-filtro-listagem">
                    {{ Form::open(array('route' => 'financeiroSaldo', 'class' => 'form', 'role' => 'form')) }}
                        <div class="form-group">
                            <div class="input-group">
                                <div class="input-group-addon">Demonstrativo</div>
                                {{ Form::select('visao', ['diario' => 'Diário', 'mensal' => 'Mensal'], Session::get('filtro_saldo.visao'), ['id' => 'dropdown_visao_saldo', 'class' => 'form-control']) }}
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="input-group">
                                <div class="input-group-addon">Período</div>
                                {{ Form::select('periodo_meses', $opcoes_mensal, Session::get('filtro_saldo.periodo_meses'), ['id' => 'dropdown_saldo_diario', 'class' => 'form-control '.$hide_mensal]) }}
                                {{ Form::select('periodo_anos', $opcoes_anual, Session::get('filtro_saldo.periodo_anos'), ['id' => 'dropdown_saldo_mensal', 'class' => 'form-control '.$hide_anual]) }}
                            </div>
                        </div>
                        <div class="form-group text-right">
                            {{ Form::button('Filtrar', ['type' => 'submit', 'class' => 'btn btn-warning']) }}
                        </div>
                    {{ Form::close() }}
                </div>
            </div>
        </div>
    </div>
@stop
