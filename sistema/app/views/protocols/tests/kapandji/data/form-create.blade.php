
<form class="form" action="{{ $action }}" method="post">
	{{ Form::token() }}
	<input type="hidden" name="treatment_id" value="{{ $treatment->id }}">

	@include('protocols.tests.form-submit')
	
	<div class="form-group" style="width: 200px;">
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

    <div class="table-responsive">
        <table class="table table-bordered" style="min-width: 800px; background: #fff;">
            <tr>
                @foreach ($scale as $item)
                    <th class="text-center" style="width: 9.2%;">
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
                                style="margin: 0; padding: 0;">
                        </label>
                    </td>
                @endforeach
            </tr>
        </table>
    </div>

</form>
