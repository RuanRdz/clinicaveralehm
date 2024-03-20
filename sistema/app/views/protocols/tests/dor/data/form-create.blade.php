
<form class="form" action="{{ $action }}" method="post">
	{{ Form::token() }}
	<input type="hidden" name="treatment_id" value="{{ $treatment->id }}">

	@include('protocols.tests.form-submit')
    
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
						<option value="{{ $id }}">{{ $name }}</option>
					@endforeach
				</select>
			</div>
		</div>
		<div class="col-xs-16 col-sm-16 col-md-12 col-lg-13">
			<div class="form-group">
				<label>Observação</label>
				<textarea name="comment" class="form-control" style="min-height: 130px"></textarea>
			</div>
		</div>
	</div>
	
</form>
