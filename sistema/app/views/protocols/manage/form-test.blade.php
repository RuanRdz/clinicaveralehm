@extends('layouts.admin.template')

@section('head')
	@parent
	<title>Sistema</title>
@stop

@section('main-panel-heading')
	@parent
	<ol class="breadcrumb">
		<li><a href="{{ route('protocols.index') }}">Protocolos</a></li>
		<li class="active">Cadastro Testes</li>
	</ol>
@stop

@section('content')

<div class="container">
	<form class="form" action="{{ $action }}" method="post">
		{{ Form::token() }}

		<div class="jumbotron">
			<div class="form-group">
				<label>Teste <sup>*</sup></label>
				<input
					type="text"
					name="name"
					value="{{ $test->name }}"
					required="true"
					class="form-control">
			</div>
			<div class="form-group">
				<label>Descrição</label>
				<textarea
					name="description"
					class="form-control"
					rows="4">{{ $test->description }}</textarea>
			</div>

			<div class="form-group">
				<label>Ordem</label>
				<input
					type="number"
					name="sort"
					value="{{ $test->sort }}"
					required="true"
					class="form-control"
					style="width: 100px;">
			</div>

			@if(Auth::user()->id == 1)
				<div class="alert alert-danger">
					<div class="form-group">
						<label>Protocol <sup>*</sup></label>
						<select
							name="protocol_id"
							required="true"
							class="form-control">
							@foreach ($protocols as $id => $name)
							  <option
									value="{{ $id }}"
									{{ $id == $test->protocol_id ? 'selected="selected"' : '' }}>
							  	{{ $name }}
							  </option>
							@endforeach
						</select>
					</div>
					<div class="form-group">
						<label>Namespace</label>
						<input
							type="text"
							name="namespace"
							value="{{ $test->namespace }}"
							class="form-control">
					</div>
					<div class="form-group">
						<label>Controllers</label>
						<input
							type="text"
							name="controllers"
							value="{{ $test->controllers }}"
							class="form-control">
					</div>
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
									{{ $en == $test->enabled ? 'selected="selected"' : '' }}>
									{{ $label }}
								</option>
							@endforeach
						</select>
					</div>
				</div>
			@endif
		</div>

		<button
			type="submit"
			class="btn btn-primary pull-right">
			Salvar
		</button>
	</form>
</div>
@stop
