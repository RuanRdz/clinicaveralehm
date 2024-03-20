

<div class="menu-protocolos-tratamento" style="display: none;">
  <div class="container-fluid">
	@foreach($menuProtocols as $speciality)

	  <h2>{{ $speciality['name'] }}</h2>

	  @foreach($speciality['protocols'] as $protocol)
		<div class="well well-sm">
		  <div class="row">

			<div class="col-xs-16 col-sm-16 col-md-5 col-lg-4">
			  <h4 style="margin-top: 0; font-weight: bold;">{{ $protocol['name'] }}</h4>
			  <p>{{ $protocol['description'] }}</p>
			</div>

			<div class="col-xs-16 col-sm-16 col-md-11 col-lg-12">

			  <div class="list-group" style="margin-bottom: 0;">
				@foreach($protocol['tests'] as $test)
				  @if ($test['route'])
					<a
					  href="{{ route($test['route'], ['treatment_id' => $tratamento->id]) }}"
					  class="list-group-item list-group-item-info"
					  style="padding-top: 6px; padding-bottom: 3px;"
					  target="_blank">
					  <div class="row">
						<div class="col-xs-16 col-sm-16 col-md-5 col-lg-5">
						  <strong>{{ $test['name'] }}</strong>
						</div>
						<div class="col-xs-16 col-sm-16 col-md-11 col-lg-11">
						  <small>{{ $test['description'] }}</small>
						</div>
					  </div>
					</a>
				  @else
					<div
					  class="list-group-item disabled"
					  style="padding-top: 6px; padding-bottom: 3px;">
					  <div class="row">
						<div class="col-xs-16 col-sm-16 col-md-5 col-lg-5">
						  <strong>{{ $test['name'] }}</strong>
						</div>
						<div class="col-xs-16 col-sm-16 col-md-11 col-lg-11">
						  <small>{{ $test['description'] }}</small>
						</div>
					  </div>
					</div>
				  @endif
				@endforeach
			  </div>

			</div>
		  </div>
		</div>

	  @endforeach
	@endforeach
  </div>
</div>
