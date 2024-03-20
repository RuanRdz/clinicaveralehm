@extends('layouts.admin.template')

@section('head')
	@parent
	<title>Sistema</title>
@stop

@section('main-panel-heading')
	@parent
	<ol class="breadcrumb">
		<li>{{ link_to_route('painel', $paciente->nome, ['id' => $paciente->id]) }}</li>
		<li class="active">Prontuário</li>
	</ol>
@stop

@section('content')

	<div class="no-print text-center mb-6">
        <button type="button" class="print-trigger btn btn-default">
            <i class="fa fa-print fa-lg"></i> Imprimir
        </button>
	</div>
    
    @if(count($prontuario) > 0)
        <div class="row">
            <div class="col-xs-16 col-sm-16 col-md-12 col-md-offset-2 col-lg-10 col-lg-offset-3">
                <div class="bg-white shadow-md">
                    {{ View::make('layouts.admin.print-header') }}
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th style="width:10%">Paciente</th>
                                <td style="width:60%">{{ $paciente->nome }}</td>
                                <th style="width:10%">RG</th>
                                <td style="width:20%">{{ $paciente->rg }}</td>
                            </tr>
                            <tr>
                                <th>Endereço</th>
                                <td>{{ $paciente->endereco }}</td>
                                <th>CPF</th>
                                <td>{{ $paciente->cpf }}</td>
                            </tr>
                            <tr>
                                <th>Cidade</th>
                                <td>{{ $paciente->cidade->nome }} / {{ $paciente->cidade->estado_uf }}</td>
                                <th>Data Nasc.</th>
                                <td>{{ $paciente->nascimento }}</td>
                            </tr>
                            <tr>
                                <th colspan="4" class="text-center">
                                    <strong>Prontuário Eletrônico</strong>
                                </th>
                            </tr>
                        </thead>
                        @foreach($prontuario as $row)
                            <tbody>
                                <tr>
                                    <td style="width: 100px!important;">
                                        <div>#{{$row->id}}</div>
                                        <div><strong>{{$row->dataprontuario}}</strong></div>
                                    </td>
                                    <td colspan="3">
                                        <div class="text-justify">
                                            {{ nl2br($row->descricao) }}
                                        </div>
                                        <div class="text-center">
                                            {{ View::make('layouts.admin.update-assinatura')->with(array('user' => $row))->render() }}
                                            <hr style="width: 60%; margin-top: 5px; margin-bottom: 5px;">
                                            Profissional: 
                                            @if($row->updatedBy) 
                                                {{$row->updatedBy->fullName}}
                                                @if($row->updatedBy->crefito)
                                                CREFITO {{ $row->updatedBy->crefito }}
                                                @endif
                                            @else 
                                                {{$row->createdBy->fullName}}
                                                @if($row->createdBy->crefito)
                                                    - {{ $row->createdBy->crefito }}
                                                @endif
                                            @endif
                                        </div>
                                    </td>
                                </tr>
                            </tbody>
                        @endforeach
                    </table>
                </div>
            </div>
        </div>
    @else
        <div class="text-center text-gray-600 text-xl my-12">
            Não há registros no prontuário
        </div>
    @endif
    
@stop
