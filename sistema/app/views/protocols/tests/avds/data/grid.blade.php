
<div class="report table-responsive" style="margin-bottom: 0">
	<table class="table" style="min-width: 800px;">
		<thead class="title">
			<tr>
				<th class="bg-gray" colspan="{{ count($scale) + 3 }}">
					@include('protocols.tests.header-report')
				</th>
			</tr>
		</thead>
		<thead class="column-title">
			<tr>
				<th class="bg-gray-light">Grupo</th>
				<th class="bg-gray-light">Atividade</th>
				@foreach($scale as $row)
					<th class="text-center bg-gray-light" style="width: 90px;">
						{{ $row->name }}
					</th>
				@endforeach
				<th class="text-center bg-white" style="width: 100px;"></th>
			</tr>
		</thead>

		<?php $group_show = $param_show = true;?>
		@foreach ($testData['grid'] as $group_name => $group)
			<tbody class="divider">
			@foreach ($group['params'] as $param_name => $param)
				@foreach ($param['data'] as $data_index => $values)
					<tr>
						@if ($group_show)
							<td 
								rowspan="{{ $group['rowspan'] }}">
								{{ $group_name }} 
							</td>
						@endif
						@if ($param_show)
							<td 
								rowspan="{{ $param['rowspan'] }}" 
								class="{{ $param['index'] != $group['sum_params'] ? 'divider-secondary' : '' }}">
								{{ $param_name }}
							</td>
						@endif

						<?php $divider_data = '';?>
						@if ($data_index == $param['rowspan'])
							<?php $divider_data = 'divider-secondary'?>
						@endif
						@if ($values['group_data_index'] == $group['rowspan'])
							<?php $divider_data = 'divider'?>
						@endif

						@foreach ($scale as $item)
							<td class="{{ $divider_data }} text-center">
								@if ($item->id == $values['scale_id'])
									<i class="fa fa-check"></i>
								@endif
							</td>
						@endforeach

						<td class="{{ $divider_data }} text-center">
							{{ timestampToBr($values['testdate']) }}
						</td>

						<td class="{{ $divider_data }} hidden-print text-center" style="width: 26px;">
                            @if ($values['treatment_id'] == $treatment->id)
                                <a 
                                    href="{{ route($routePath.'.edit', ['id' => $values['id']]) }}"
                                    style="font-size: 1.5em; color: blue;">
                                    <i class="fa fa-pencil"></i>
                                </a>
                            @else 
                                <i 
                                    class="fa fa-pencil text-muted" 
                                    style="font-size: 1.5em;" 
                                    title="Tratamento #{{$values['treatment_id']}}">
                                </i>
                            @endif
						</td>
						<td class="{{ $divider_data }} hidden-print text-center" style="width: 26px;">
							<a
                                href="{{ route($routePath.'.destroy', ['id' => $values['id']]) }}"
                                class="btn-delete confirm-destroy">
                                <i class="fa fa-times"></i>
                            </a>
						</td>
					</tr>
					<?php $group_show = $param_show = false;?>
				@endforeach
				<?php $param_show = true;?>
			@endforeach
			<?php $group_show = true;?>
		</tbody>
		@endforeach
	</table>
</div>

<div class="report">
	<table>
		<thead class="title">
			<tr>
				<th colspan="{{ count($scale) + 2 }}" class="text-center">Posicional AVD's</th>
			</tr>
		</thead>
		<thead class="column-title">
			<tr>
				<th class="bg-white" style="width: 20%;"></th>
				@foreach($scale as $row)
					<th class="text-center bg-gray-light">
						{{ $row->name }}
					</th>
				@endforeach
				<th class="text-center bg-white" style="width: 20%;">Nº itens avaliados</th>
			</tr>
		</thead>
		<tbody>
			@foreach($testData['result'] as $testdate => $values)
				<tr>
                    <td style="text-align: center;">
                        {{ timestampToBr($testdate) }}
                    </td>
					@foreach($scale as $row)
						<th class="text-center bg-gray-light">
							{{ isset($values['result'][$row->id]) ? $values['result'][$row->id]['percent'] : 0 }}%
						</th>
					@endforeach
					<td class="text-center">
                        {{ $values['numOfItems'] }}
                    </td>
				</tr>
			@endforeach
		</tbody>
	</table>
</div>
