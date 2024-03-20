
<form class="form" action="{{ $action }}" method="post">
	{{ Form::token() }}
	<input type="hidden" name="treatment_id" value="{{ $treatment->id }}">

	@include('protocols.tests.form-submit')
	
	<div class="row">
		<div class="col-xs-8 col-sm-3 form-group">
            <label>Movimento</label>
			<button type="button" class="btn btn-primary btn-block" id="js-open-modal-funcamuscular">
				Selecionar
			</button>
		</div>
		<div class="col-xs-16 col-sm-9 form-group">
            <label>.</label>
            <input type="text" id="js-input-funcaomuscular-param_label" class="form-control" readonly="readonly">
            <input type="hidden" name="param_id" id="js-input-funcaomuscular-param_id">
		</div>
        <div class="col-xs-8 col-sm-4 form-group">
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

</form>


