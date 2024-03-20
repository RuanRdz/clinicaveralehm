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
                        <div class="col-xs-16 col-sm-16 col-md-10 col-lg-11">
                            <div class="form-group">
                                <label>Atividade <sup>*</sup></label>
                                <select
                                    name="param_id"
                                    class="form-control"
                                    title="Selecionar Movimento">
                                    @foreach ($paramgroups as $group)
                                        <optgroup label="{{ $group->name }}">
                                            @foreach ($group->params as $param)
                                                <option 
                                                    value="{{ $param->id }}"
                                                    {{$param->id == $data->param_id ? 'selected' : ''}}>
                                                    {{ $param->name }}
                                                </option>
                                            @endforeach
                                        </opgroup>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-xs-10 col-sm-8 col-md-6 col-lg-5">
                            <div class="form-group">
                                <label>Ação</label>
                                <select
                                    name="scale_id"
                                    class="form-control"
                                    title="Selecionar Ação">
                                    @foreach ($scale as $item)
                                        <option 
                                            value="{{ $item->id }}" 
                                            {{ $item->id == $data->scale_id ? 'selected' : '' }}>
                                            {{ $item->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
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
