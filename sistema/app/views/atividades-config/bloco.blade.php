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
		<li><a href="{{ route('atividadesconfig') }}">Parâmetros de atividade</a></li>
		<li class="active"><a href="{{ route('atividadesconfigShow', ['bloco' => $bloco]) }}">{{ $descricao }}</a></li>
	</ol>
@stop

@section('content')
    <div ng-controller="ListRecursos">
        <div class="row">
            <div class="col-xs-16 col-lg-14 col-lg-offset-1">
                <div class="row">
                    <div class="col-sm-16 col-md-4">
                        @include('atividades-config.menu')
                    </div>
                    <div class="col-sm-16 col-md-11 col-md-offset-1">
                        <div class="mb-3 text-right">
                            <button
                                type="button"
                                class="btn btn-primary"
                                ng-click="linkTableRow('{{route('atividadesconfigCreate', ['id' => $bloco])}}')"
                            >
                                <i class="fa fa-plus fa-fw"></i> Cadastrar
                            </button>
                        </div>
                        <div class="bg-white shadow">
                            <table class="table table-striped valign-middle border-0">
                                <tbody class="js-sort-items-atividades-config">
                                    @foreach ($dados as $item)
                                        <tr 
                                            ng-click="linkTableRow('{{route('atividadesconfigEdit', ['id' => $item->id])}}')"
                                            data-item-id="{{ $item->id }}"
                                            class="cursor-pointer grabbable"
                                        >
                                            <td class="text-muted" style="width:40px">
                                                {{ $item->ordem }}
                                            </td>
                                            @if($item->bloco == 'C')
                                                <td style="width:30%">
                                                    {{ $opcoesAtividade[$item->opcao_atividade] }}
                                                </td>
                                            @endif
                                            <td>
                                                {{ $item->nome }}
                                            </td>
                                            <td class="w-1 text-gray-500 cursor-move" title="Mover posição">
                                                <i class="fa fa-arrows"></i>
                                            </td>
                                        </tr>
                                    @endforeach
                                </body>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@stop