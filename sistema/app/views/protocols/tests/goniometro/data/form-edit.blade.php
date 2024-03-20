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
                    <div class="form-group">
                        <label>Movimento <sup>*</sup></label>
                        <select
                            name="param_id"
                            class="form-control"
                            title="Selecionar Movimento">
                            @foreach ($params as $group => $options)
                                <optgroup label="{{ $group }}">
                                    @foreach ($options as $id => $option)
                                        <option 
                                            value="{{ $id }}"
                                            {{$id == $data->param_id ? 'selected' : ''}}>
                                            {{ $option }}
                                        </option>
                                    @endforeach
                                </opgroup>
                            @endforeach
                        </select>
                    </div>

                    <div class="row">
                        <div class="col-xs-6 col-sm-4 col-md-3 col-lg-3">
                            <div class="form-group">
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
                        <div class="col-xs-5 col-sm-3 col-md-2 col-lg-2">
                            <div class="form-group">
                                <label>Grau Ativo</label>
                                <input 
                                    type="number" 
                                    name="degree_active" 
                                    class="form-control" 
                                    value="{{ $data->degree_active }}">
                            </div>
                        </div>
                        <div class="col-xs-5 col-sm-3 col-md-2 col-lg-2">
                            <div class="form-group">
                                <label>Grau Passivo</label>
                                <input 
                                    type="number" 
                                    name="degree_passive" 
                                    class="form-control" 
                                    value="{{ $data->degree_passive }}">
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
