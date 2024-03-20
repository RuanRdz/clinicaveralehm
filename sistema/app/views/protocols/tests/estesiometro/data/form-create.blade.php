
<form id="estesiometro-data-form" class="form" action="{{ $action }}" method="post">
	{{ Form::token() }}
	<input type="hidden" name="treatment_id" value="{{ $treatment->id }}">
	<input type="hidden" name="svg" value="">

	@include('protocols.tests.form-submit')

	<div class="row">
		<div class="col-xs-16 col-sm-8 col-md-6 col-lg-4 col-sm-offset-4 col-md-offset-5 col-lg-offset-6">
			<div class="text-center">
				<div class="btn-group" role="group" style="z-index: 1">
					<button
						type="button"
						class="btn-sorri-hand btn btn-primary"
						data-svgref="sorri-right-hand">
						Direita
					</button>
					<button
						type="button"
						class="btn-sorri-hand btn btn-primary"
						data-svgref="sorri-left-hand">
						Esquerda
					</button>
				</div>
				<div id="estesiometro-maps">
					@include('protocols.tests.estesiometro.data.maps')
				</div>
			</div>
		</div>
	</div>
</form>

@include('protocols.tests.estesiometro.data.scale')
