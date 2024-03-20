
<div class="report">
	<table style="margin-bottom: 10px;">
		<thead class="title">
			<tr>
				<th class="bg-gray">
					@include('protocols.tests.header-report')
					<button 
						type="button"
						class="btn btn-link hidden-print js-estesiometro-btn-disable-colors"
						title="Remover cores para impressão">
						<i class="fa fa-tint fa-lg"></i>
					</button>
				</th>
			</tr>
		</thead>
		<tbody>
			<td>
				<div class="clearfix estesiometro-container js-estesiometro-container">
					@foreach ($testData as $row)
						<div class="estesiometro-item">
							<div class="panel panel-default">
								<div class="body">
									{{ $row->svg }}
								</div>
								<div class="panel-footer">
									{{ $row->testdate }}
									<a
										href="{{ route($routePath.'.destroy', ['id' => $row->id]) }}"
										class="btn-delete confirm-destroy hidden-print"><i class="fa fa-times"></i></a>
								</div>
							</div>
						</div>
					@endforeach
				</div>
			</td>
		</tbody>
	</table>
				
	@include('protocols.tests.estesiometro.data.legend')
</div>
