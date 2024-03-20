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

				<div class="form-group">
					<label>Score</label>
					<input
						type="number"
						name="score"
						value="{{ $data->score }}"
						required="true"
						class="form-control"
						style="width: 100px;">
				</div>

				<div class="form-group">
					<label>Legenda</label>
					<input
					type="text"
					name="name"
					value="{{ $data->name }}"
					class="form-control">
				</div>

				<div class="form-group">
					<label>Cor</label>
					<input
						type="text"
						name="color"
						value="{{ $data->color }}"
						required="true"
						class="form-control"
						style="width: 100px;">
				</div>

				<div class="form-group">
					<label>Imagem</label>
					<input
					type="text"
					name="image"
					value="{{ $data->image }}"
					class="form-control">
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
