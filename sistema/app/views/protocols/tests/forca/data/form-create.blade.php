
<form class="form" action="{{ $action }}" method="post">
	{{ Form::token() }}
	<input type="hidden" name="treatment_id" value="{{ $treatment->id }}">

	@include('protocols.tests.form-submit')
	
	<div class="row">
        <div class="col-lg-2"></div>
		@foreach ($params as $param)
			<div class="col-xs-16 col-sm-4 col-md-4 col-lg-2">
				<div class="panel panel-default">
					<div class="panel-heading" style="min-height: 60px">
						<strong>{{ $param->name }}</strong>
					</div>
					<div class="panel-body">
						<div class="form-group">
							<label class="font-normal text-red-700">
								{{ $hands['right'] }}
							</label>
							<select
								name="values[{{$param->id}}][right]"
								class="form-control"
								title="Peso">
								@foreach ($scale as $id => $weight)
									<?php
									$style = ''; 
									if (strpos($weight, '-') !== false) {
										$style = 'color: #808080 !important;'; 
									}
									if($weight == '0 kg') {
										$style = 'font-weight: bold !important;'; 
									}
									?>
									<option value="{{ $id }}" style="{{ $style }}">
										{{ $weight }}
									</option>
								@endforeach
							</select>
						</div>
						<div class="form-group">
							<label class="font-normal">
								{{ $hands['left'] }}
							</label>
							<select
								name="values[{{$param->id}}][left]"
								class="form-control"
								title="Peso">
								@foreach ($scale as $id => $weight)
									<?php
									$style = ''; 
									if (strpos($weight, '-') !== false) {
										$style = 'color: #808080 !important;'; 
									}
									if($weight == '0 kg') {
										$style = 'font-weight: bold !important;'; 
									}
									?>
									<option value="{{ $id }}" style="{{ $style }}">
										{{ $weight }}
									</option>
								@endforeach
							</select>
						</div>
					</div>
				</div>
			</div>
		@endforeach
	</div>
</form>
