@extends('layouts.admin.template')

@section('head')
	@parent
	<title>Sistema</title>
@stop

@section('main-panel-heading')
	@parent
	<ol class="breadcrumb">
		<li>
			<a href="{{ route('painel', ['id' => $treatment->paciente->id, 'id2' => $treatment->id]) }}">
				{{ $treatment->paciente->nome }}
			</a>
		</li>
		<li class="active">
			<a href="{{ route($routePath.'.index', ['treatment_id' => $treatment->id]) }}">
				{{ $test->name }}
			</a>
		</li>
	</ol>
@stop

@section('content')
	<div class="container">

		<form class="form" action="{{ $action }}" method="post">
			{{ Form::token() }}
            <input type="hidden" name="id" value="{{ $data->id }}">
            <input type="hidden" name="treatment_id" value="{{ $treatment->id }}">

			<div class="panel panel-default">
				<div class="panel-heading">
					@include('protocols.tests.header-form')
				</div>
				<div class="panel-body" style="background: #D0F5F7;">
                    <!-- test -->
                    <div class="table-responsive">
                        <table class="table table-bordered" style="min-width: 800px;">
                            <tr>
                                @foreach ($scale as $item)
                                    <th class="text-center" style="width: 9.2%; background: {{ $item->color }} !important;">
                                        <label for="scoreRadio{{ $item->id }}" style="display: block; height: 100%;">
                                            <div style="font-size: 1.3em;">{{ $item->score }}</div>
                                            <div style="font-weight: normal;">{{ $item->name }}</div>
                                        </label>
                                    </th>
                                @endforeach
                            </tr>
                            <tr>
                                @foreach ($scale as $item)	
                                    <td class="text-center">
                                        <label
                                            for="scoreRadio{{ $item->id }}"
                                            class="list-group-item"
                                            style="padding-top: 10px; padding-bottom: 10px; display: block; width: 100%;">
                                            <input
                                                id="scoreRadio{{ $item->id }}"
                                                type="radio"
                                                name="scale_id"
                                                value="{{ $item->id }}"
                                                {{ $item->id == $data->scale_id ? 'checked': '' }}
                                                style="margin: 0; padding: 0;">
                                        </label>
                                    </td>
                                @endforeach
                            </tr>
                        </table>
                    </div>
                    <div class="row">
                        <div class="col-xs-16 col-sm-16 col-md-4 col-lg-3">
                            <div class="form-group" style="width: 100%;">
                                <label>Tipo</label>
                                <select
                                    name="type_id"
                                    class="form-control">
                                    @foreach ($types as $id => $name)
                                        <option 
                                            value="{{ $id }}"
                                            {{$id == $data->type_id ? 'selected' : ''}}
                                        >
                                            {{ $name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-xs-16 col-sm-16 col-md-12 col-lg-13">
                            <div class="form-group">
                                <label>Observação</label>
                                <textarea name="comment" class="form-control" style="min-height: 130px">{{$data->comment}}</textarea>
                            </div>
                        </div>
                    </div>
                    <!-- test -->
				</div>
				<div class="panel-footer clearfix hidden-print text-right">
                    <div class="row">
                        <div class="col-xs-16 col-sm-16 col-md-4">
                            <label style="margin-top: 10px">
                                <i class="fa fa-calendar"></i> Avaliado em: <sup>*</sup>
                            </label>
                        </div>
                        <div class="col-xs-16 col-sm-16 col-md-4">
                            <div class="form-group">
                                <input
                                    type="text"
                                    name="testdate"
                                    required="true"
                                    value="{{ $data->testdate }}"
                                    class="form-control datepicker">
                            </div>
                        </div>
                        <div class="col-xs-8 col-sm-8 col-md-4">
                            <button
                                type="submit"
                                class="btn btn-info">
                                SALVAR EDIÇÃO
                            </button>
                        </div>
                        <div class="col-xs-8 col-sm-8 col-md-4">
                            <a 
                                href="{{ route($routePath.'.index', ['treatment_id' => $treatment->id]) }}"
                                class="btn btn-default">
                                CANCELAR
                            </a>
                        </div>
                    </div>
				</div>
			</div>

		</form>
	</div>
@stop
