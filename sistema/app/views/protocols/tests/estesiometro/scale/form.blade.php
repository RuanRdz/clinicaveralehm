@extends('layouts.admin.template')

@section('head')
	@parent
	<title>Sistema</title>
@stop

@section('main-panel-heading')
	@parent
    <ol class="breadcrumb">
		<li><a href="{{ route('protocols.index') }}">Protocolos</a></li>
		<li>{{ $test->name }}</li>
		<li><a href="{{ route($routePath.'.index') }}">Escala</a></li>
		<li class="active">Cadastro</li>
	</ol>
@stop

@section('content')
	<div class="container">
		<form class="form" action="{{ $action }}" method="post">
			{{ Form::token() }}

			<div class="jumbotron">

				<div class="row">

					<div class="col-xs-16 col-sm-4 col-md-4 col-lg-4">
						<div class="form-group">
		    			<label>Código <sup>*</sup></label>
							<input
								type="number"
								name="code"
								value="{{ $data->code }}"
								required="true"
								class="form-control">
						</div>
					</div>

					<div class="col-xs-16 col-sm-4 col-md-4 col-lg-4">
						<div class="form-group">
							<label>Cor <sup>*</sup></label>
							<input
								type="text"
								name="colorname"
								value="{{ $data->colorname }}"
								required="true"
								class="form-control">
						</div>
					</div>

					<div class="col-xs-16 col-sm-4 col-md-4 col-lg-4">
						<div class="form-group">
							<label>Cor (Hex) <sup>*</sup></label>
							<input
								type="text"
								name="colorhex"
								value="{{ $data->colorhex }}"
								required="true"
								class="form-control">
						</div>
					</div>

					<div class="col-xs-16 col-sm-4 col-md-4 col-lg-4">
						<div class="form-group">
							<label>Ordem</label>
							<input
								type="number"
								name="sort"
								value="{{ $data->sort }}"
								required="true"
								class="form-control">
						</div>
					</div>

				</div>

				<div class="form-group">
    			<label>Descrição</label>
					<textarea
						name="description"
						class="form-control"
						rows="4">{{ $data->description }}</textarea>
				</div>

				@if(Auth::user()->id == 1)
					<div class="alert alert-danger">
						<div class="form-group">
							<label>Enabled <sup>*</sup></label>
							<select
								name="enabled"
								required="true"
								class="form-control"
								style="width: 100px;">
								@foreach ([1 => 'Yes', 0 => 'No'] as $en => $label)
									<option
										value="{{ $en }}"
										{{ $en == $data->enabled ? 'selected="selected"' : '' }}>
										{{ $label }}
									</option>
								@endforeach
							</select>
						</div>
					</div>
				@endif

			</div>

			<p class="clearfix hidden-print">
				<button
					type="submit"
					class="btn btn-primary pull-right">
					Salvar
				</button>
			</p>
		</form>
	</div>
@stop
