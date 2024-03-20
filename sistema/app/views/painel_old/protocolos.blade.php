<div class="panel panel-default">
	
	<div class="panel-heading">
		<div class="text-primary">
			<strong>Protocolos</strong>
		</div>
	</div>
	
	<div class="panel-body">

		<table class="table table-sm">
			@foreach($menuProtocols as $specialty)
				<?php if(count($specialty['protocols']) == 0) { continue; } ?>
				<thead>
					<tr>
						<th 
							colspan="4" 
							style="padding-top: 15px; padding-bottom: 15px; font-weight: normal; background: #e7e7e7;">
							{{ $specialty['name'] }}
						</th>
					</tr>
				</thead>
				@foreach($specialty['protocols'] as $protocol)
					<tbody>
						<tr>
							<td 
								colspan="4" 
								style="padding-top: 12px; padding-bottom: 8px; background: #f1f1f1;">
								{{ $protocol['name'] }}
							</td>
						</tr>
						@foreach($protocol['tests'] as $test)
							<tr>
								<td>
									@if ($test['route'])
										<a
											href="{{ route($test['route'], ['treatment_id' => $tratamento->id]) }}"
											style="display: block"
											target="_blank">
											{{ $test['name'] }}
										</a>
									@else
										<span style="color: #707070;">{{ $test['name'] }}</span>
									@endif
								</td>
								<td style="color: #909090;">
									<small>{{ $test['description'] }}</small>
								</td>
								<td style="width: 90px;">
									@if(isset($datasUltimasAvaliacoes[$test['namespace']]))
										{{ timestampToBr($datasUltimasAvaliacoes[$test['namespace']]) }}
									@endif
								</td>
							</tr>
						@endforeach
					</tbody>
				@endforeach
			@endforeach
		</table>
	</div>
</div>
