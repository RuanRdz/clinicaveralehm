@extends('layouts.admin.template')

@section('head')
	@parent
	<title>Sistema</title>
@stop

@section('main-panel-heading')
	@parent
	<ol class="breadcrumb">
		<li>Financeiro</li>
		<li class="active">Recibo</li>
	</ol>
@stop

@section('content')

	<div class="no-print text-center mb-6">
        <button type="button" class="print-trigger btn btn-default">
            <i class="fa fa-print fa-lg"></i> Imprimir
        </button>
	</div>

    <div class="row">
        <div class="col-md-12 col-md-offset-2 col-lg-10 col-lg-offset-3">
            <div class="border border-gray-500 p-6">
                <div class="mb-6 text-xl">
                    <img 
                        src="{{ URL::asset('img/vera-lehm-dashboard-logotype.png') }}" 
                        style="display: inline; width: 30px; height: 30px;"
                    />
                    {{ Sistema::parametros()['empresa'] }}
                </div>
                <div class="mb-6">
                    <table class="w-full">
                        <tr>
                            <td class="text-2xl font-bold w-1/2" contenteditable="true">
                                RECIBO {{ $recibo['numero'] }}
                            </td>
                            <td class="text-2xl font-bold text-right" contenteditable="true">
                                R${{ $recibo['valor'] }}
                            </td>
                        </tr>
                    </table>
                </div>
                <div class="mb-6 leading-normal text-justify" contenteditable="true">
                    Recebi(emos) de <strong>{{ $recibo['recebido_de'] }}</strong> 
                    registrado sob o documento <strong>{{ $recibo['documento'] }}</strong>, 
                    a importância de <strong>R${{ $recibo['valor'] }}</strong>, 
                    referente a(o) <strong>{{ $recibo['descricao'] }}</strong>.
                    <br>
                    <br>
                    Para maior clareza, firmo(amos) o presente.
                </div>
                <div class="mb-20 text-center" contenteditable="true">
                    {{ $recibo['data_recibo'] }}
                </div>
                <div class="text-center">
                    <div>
                        <hr class="mb-1 w-2/4 border-gray-600">
                    </div>
                    <div class="mb-3" contenteditable="true">
                        {{ $recibo['nome_emitente'] }}
                    </div>
                    <div class="text-center text-sm" contenteditable="true">
                        {{ $s['razao_social'] }} - CREFITO {{ $s['crefito'] }} - {{ $s['endereco'] }} - {{ $s['cidade'] }}
                        <br />
                        {{ $s['telefone'] }} / E-mail: {{ $s['email'] }}
                    </div>
                </div>
            </div>
        </div>
    </div>

@stop
