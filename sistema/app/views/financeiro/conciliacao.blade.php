@extends('layouts.admin.template')

@section('head')
	@parent
	<title>Sistema</title>
@stop

@section('main-panel-heading')
	@parent
	<ol class="breadcrumb">
		<li>Financeiro</li>
		<li class="active">Conciliação</li>
	</ol>
@stop

@section('content')

    <div id="modal_form_conciliacao" class="modal ui-front" tabindex="-1" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                </div>
                <div class="modal-body">
                    <form action="{{route('financeiroConciliacaoUpload')}}" method="POST" enctype="multipart/form-data" class="form-inline">
                        <div class="p-12">
                            <div class="form-group w-4/5">
                                <label>Selecionar Planilha <sup>*</sup></label>
                                <input type="file" name="arquivo" required>
                                <div class="mt-3">Extensão: <span class="text-primary">.xls</span> ou <span class="text-primary">.xlsx</span></div>
                            </div>
                            <button type="submit" class="btn btn-primary mt-3">
                                Processar
                            </button>
                            <div class="mt-12 text-sm text-gray-700">Modelo</div>
                            <table class="table table-bordered">
                                <tr>
                                    <th style="width: 30px;" class="bg-gray-300 text-gray-600"></th>
                                    <th class="bg-gray-200 text-gray-700 font-bold text-center">A</th>
                                    <th class="bg-gray-200 text-gray-700 font-bold text-center">B</th>
                                    <th class="bg-gray-200 text-gray-700 font-bold text-center">C</th>
                                </tr>
                                <tr>
                                    <td class="bg-gray-200 text-gray-600 text-center">1</td>
                                    <td class="text-gray-500">CÓDIGO</td>
                                    <td class="text-gray-500">VALOR (R$)</td>
                                    <td class="text-gray-500">FAVORECIDO</td>
                                </tr>
                                <tr>
                                    <td class="bg-gray-200 text-gray-600 text-center">2</td>
                                    <td class="text-black">9999</td>
                                    <td class="text-black">1.000,00</td>
                                    <td class="text-black">NOME DO FAVORECIDO</td>
                                </tr>
                            </table>
                            <div class="text-sm text-gray-600">Os dados serão lidos a partir da linha 2</div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div class="col-xs-16 text-center mb-8">
        <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#modal_form_conciliacao">
            Carregar dados
        </button>
    </div>

    @if(count($dados))
        <table class="table table-bordered table-hover valign-middle shadow bg-white">
            <thead>
                <tr>
                    <th colspan="3" class="text-center bg-gray-200 text-lg">Dados Planilha</th>
                    <th colspan="4" class="text-center bg-yellow-200 text-lg">Lançamentos</th>
                </tr>
                <tr>
                    <th>Código</th>
                    <th>Favorecido</th>
                    <th style="width: 100px;">Valor</th>
                    <!--  -->
                    <th>Favorecido</th>
                    <th style="width: 100px;">Valor</th>
                    <th style="width: 100px;">Valor pago</th>
                    <th style="width: 70px;">ID</th>
                </tr>
            </thead>
            <tbody>
                @foreach($dados as $item)
                    <?php $rowspan = count($item['lancamentos']);?>
                    @if($rowspan == 0)
                        <tr>
                            <td>{{ $item['sheet_codigo'] }}</td>
                            <td>{{ $item['sheet_favorecido'] }}</td>
                            <td>{{ $item['sheet_valor'] }}</td>
                            <td colspan="4" class="text-red-600">Nenhum lançamento encontrado</td>
                        </tr>
                    @elseif($rowspan == 1)
                        <tr>
                            <td>{{ $item['sheet_codigo'] }}</td>
                            <td>{{ $item['sheet_favorecido'] }}</td>
                            <td>{{ $item['sheet_valor'] }}</td>
                            <td class="{{ $item['lancamentos'][0]['color'] }}">{{ $item['lancamentos'][0]['db_favorecido'] }}</td>
                            <td class="{{ $item['lancamentos'][0]['color'] }}">{{ $item['lancamentos'][0]['db_valor'] }}</td>
                            <td class="{{ $item['lancamentos'][0]['color'] }}">{{ $item['lancamentos'][0]['db_valor_pago'] }}</td>
                            <td class="text-gray-500">{{ $item['lancamentos'][0]['id'] }}</td>
                        </tr>
                    @else 
                        <tr>
                            <td rowspan="{{ $rowspan }}">{{ $item['sheet_codigo'] }}</td>
                            <td rowspan="{{ $rowspan }}">{{ $item['sheet_favorecido'] }}</td>
                            <td rowspan="{{ $rowspan }}">{{ $item['sheet_valor'] }}</td>
                            <td class="{{ $item['lancamentos'][0]['color'] }}">{{ $item['lancamentos'][0]['db_favorecido'] }}</td>
                            <td class="{{ $item['lancamentos'][0]['color'] }}">{{ $item['lancamentos'][0]['db_valor'] }}</td>
                            <td class="{{ $item['lancamentos'][0]['color'] }}">{{ $item['lancamentos'][0]['db_valor_pago'] }}</td>
                            <td class="text-gray-500">{{ $item['lancamentos'][0]['id'] }}</td>
                        </tr>
                        <?php unset($item['lancamentos'][0]);?>
                        @foreach($item['lancamentos'] as $lancamento)
                        <tr>
                            <td class="{{ $lancamento['color'] }}">{{ $lancamento['db_favorecido'] }}</td>
                            <td class="{{ $lancamento['color'] }}">{{ $lancamento['db_valor'] }}</td>
                            <td class="{{ $lancamento['color'] }}">{{ $lancamento['db_valor_pago'] }}</td>
                            <td class="text-gray-500">{{ $lancamento['id'] }}</td>
                        </tr>
                        @endforeach
                    @endif
                @endforeach
            </tbody>
        </table>
    @else
        <div class="text-xl text-center text-gray-400 mt-12">
            Sem dados para exibição. Clique "Carregar dados" para começar.
        </div>
    @endif
@stop
