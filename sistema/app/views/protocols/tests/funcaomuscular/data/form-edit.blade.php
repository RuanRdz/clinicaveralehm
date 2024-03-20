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
                    <div class="row">
                        <div class="col-xs-8 col-sm-3 form-group">
                            <label>Movimento</label>
                            <button type="button" class="btn btn-primary btn-block" id="js-open-modal-funcamuscular">
                                Selecionar
                            </button>
                        </div>
                        <div class="col-xs-16 col-sm-9 form-group">
                            <label>.</label>
                            <input type="text" value="{{$data->param->muscle}} - {{$data->param->moviment}}" id="js-input-funcaomuscular-param_label" class="form-control" readonly="readonly">
                            <input type="hidden" name="param_id" value="{{$data->param_id}}" id="js-input-funcaomuscular-param_id">
                        </div>
                        <div class="col-xs-8 col-sm-4 form-group">
                            <label>Lado</label>
                            <select
                                name="side_id"
                                class="form-control"
                                title="Selecionar Lado">
                                @foreach ($sides as $id => $name)
                                    <option 
                                        value="{{ $id }}" 
                                        {{ $id == $data->side_id ? 'selected' : '' }}>
                                        {{ $name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    
                    <div class="row">
                        <div class="col-xs-16">
                            <label>Grau <sup>*</sup></label>
                            <div class="list-group">
                                @foreach ($scale as $item)
                                    <label
                                        for="degreeRadio{{ $item->id }}"
                                        class="list-group-item"
                                        style="font-weight: normal; padding-top: 5px; padding-bottom: 5px; line-height: 16px; display: table; width: 100%;">
                                        <span style="display: table-cell; width: 20px; vertical-align: middle;">
                                            <input
                                                id="degreeRadio{{ $item->id }}"
                                                type="radio"
                                                name="scale_id"
                                                value="{{ $item->id }}"
                                                {{ $item->id == $data->scale_id ? 'checked' : '' }}
                                                style="margin: 0; padding: 0;">
                                        </span>
                                        <span style="display: table-cell; width: 50px; font-weight: bold; text-align: center; vertical-align: middle;">
                                            {{ $item->name }}
                                        </span>
                                        <span style="display: table-cell; vertical-align: middle;">
                                            {{ $item->description }}
                                        </span>
                                    </label>
                                @endforeach
                            </div>
                        </div>
                    </div>

                    @include('protocols.tests.'.$routePath.'.modal-params')
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
                        <div class="col-xs-8 col-sm-16 col-md-4">
                            <button
                                type="submit"
                                class="btn btn-info">
                                SALVAR EDIÇÃO
                            </button>
                        </div>
                        <div class="col-xs-8 col-sm-16 col-md-4">
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
