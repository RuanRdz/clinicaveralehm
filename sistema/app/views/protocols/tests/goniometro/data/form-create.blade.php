
<form class="form" action="{{ $action }}" method="post">
	{{ Form::token() }}
	<input type="hidden" name="treatment_id" value="{{ $treatment->id }}">
	
	@include('protocols.tests.form-submit')

	<div class="form-group">
		<label>Movimento <sup>*</sup></label>
		<select
			name="param_id"
			class="form-control"
			title="Selecionar Movimento">
			@foreach ($params as $group => $options)
				<optgroup label="{{ $group }}">
					@foreach ($options as $id => $option)
						<option value="{{ $id }}">{{ $option }}</option>
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
                        <option value="{{ $id }}" {{ $id == \Input::old('side_id') ? 'selected' : '' }}>{{ $name }}</option>
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
					value="{{ \Input::old('degree_active') }}">
			</div>
		</div>
		<div class="col-xs-5 col-sm-3 col-md-2 col-lg-2">
			<div class="form-group">
				<label>Grau Passivo</label>
				<input 
					type="number" 
					name="degree_passive" 
					class="form-control" 
					value="{{ \Input::old('degree_passive') }}">
			</div>
		</div>
	</div>
</form>
