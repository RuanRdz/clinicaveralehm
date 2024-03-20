@extends('layouts.admin.template')

@section('head')
	@parent
	<title>Sistema</title>
@stop

@section('main-panel-heading')
	@parent
	<ol class="breadcrumb">
		<li>Financeiro</li>
		<li class="active">Produção Profissionais</li>
	</ol>
@stop

@section('content')

    <div class="alert alert-warning text-center text-xl">
        <i class="fa fa-exclamation-triangle fa-lg"></i> Somente particular
    </div>

    <div class="p-4 bg-gray-200">
        {{ Former::open()->secure()->action(route('financeiroProducao'))->required() }}
        <div class="row">
            <div class="col-md-4 col-md-offset-2">
                {{ Former::select('profissional')->options($filtro['profissionais'])->select($params['profissional'])->addClass('form-control')->required() }}
            </div>
            <div class="col-md-2">
                {{ Former::select('comissao')->options($filtro['comissoes'])->select($params['comissao'])->addClass('form-control')->required() }}
            </div>
            <div class="col-md-3">
                {{ Former::select('mes')->options($filtro['meses'])->select($params['mes'])->addClass('form-control')->required() }}
            </div>
            <div class="col-md-2">
                {{ Former::select('ano')->options($filtro['anos'])->select($params['ano'])->addClass('form-control')->required() }}
            </div>
            <div class="col-md-2 pt-8">
                {{ Form::button('Filtrar', ['type' => 'submit', 'class' => 'btn btn-warning']) }}
            </div>
        </div>
        {{ Form::close() }}
    </div>

    @if (!count($resultado['dados']))
        <div class="py-12 text-center text-gray-400 text-3xl">
            Selecione o profissional para carregar os dados
        </div>
    @else 
        <div class="flex content-center items-center justify-around text-center bg-red-200 p-8 text-xl text-gray-600">
            <div class="opacity-75">Total Valor: <span class="text-gray-800">{{$resultado['t_valor']}}</span></div>
            <div class="opacity-75">Total Valor Recebido: <span class="text-gray-800">{{$resultado['t_valor_pago']}}</span></div>
            <div class="text-black">Total Comissão do Profissional: <span class="font-bold text-2xl text-red-600">{{$resultado['t_valor_comissao']}}</span></div>
        </div>
        <table class="table table-condensed table-bordered table-hover valign-middle text-sm">
            <thead>
                <th class="w-12">ID</th>
                <th style="width:60px;">Tratamento</th>
                <th style="width:150px;">Código/Guia</th>
                <th style="width:100px;">Competência<br>Emissão</th>
                <th style="width:100px;">Vencimento<br>Previsão</th>
                <th style="width:100px;" class="bg-gray-200">Pagamento<br>Concluído</th>
                <th style="width:70px;" class="bg-gray-200 text-right">Valor</th>
                <th style="width:80px;" class="bg-gray-200 text-right">Valor Recebido</th>
                <th style="width:130px;" class="bg-gray-200 text-right">Comissão<br><span class="text-sm font-normal">(sobre valor recebido)</span></th>
                <th style="width:130px;">Convênio</th>
                <th>Paciente</th>
                <th>Observação</th>
                <th>Conta</th>
            </thead>
            <tbody>
                @foreach($resultado['dados'] as $row)
                    <tr>
                        <td class="text-gray-500">
                            #{{ $row->id }}
                        </td>
                        <td>
                            <a class="cursor-pointer" href="{{ route('painel', ['id' => $row['tratamento']['paciente_id'], 'id2' => $row['tratamento_id']]).'#tab-financeiro' }}" target="_blank">#{{ $row->tratamento_id }}</a>
                        </td>
                        <td>
                            {{ $row->codigo }}
                        </td>
                        <td>
                            {{ $row->emissao }}
                        </td>
                        <td>
                            {{ $row->vencimento }}
                        </td>
                        <td class="font-bold text-primary">
                            {{ $row->pagamento }}
                        </td>
                        <td class="text-right">
                            {{ $row->valor }}
                        </td>
                        <td class="font-bold text-right">
                            {{ $row->valor_pago }}
                        </td>
                        <td class="font-bold text-right text-primary">
                            {{ valorBr($row->valor_comissao) }}
                        </td>
                        <td class="text-sm">
                            @if(!is_null($row->tratamento))
                                @if(!is_null($row->tratamento->convenio))
                                    {{$row->tratamento->convenio->nome}}
                                @endif
                            @endif
                        </td>
                        <td class="text-sm">
                            @if(!is_null($row->tratamento))
                                @if(!is_null($row->tratamento->paciente))
                                    {{ $row->tratamento->paciente->nome }}
                                @endif
                            @endif
                        </td>
                        <td class="text-sm">
                            {{ $row->observacao }}
                        </td>
                        <td class="text-sm">
                            {{ !is_null($row->conta) ? $row->conta->nome : '' }}
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @endif 
@stop
