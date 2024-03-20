
<div class="report table-responsive">
	<table class="table" style="min-width: 800px;">
		<thead class="title">
			<tr>
				<th class="bg-gray" colspan="{{ count($scale) + 4 }}">
					@include('protocols.tests.header-report')
				</th>
			</tr>
		</thead>
		<thead class="column-subtitle">
			<tr>
				<th class="bg-gray-light" colspan="2"></th>
				<th class="text-center bg-gray-light" colspan="{{ count($scale) }}">Grau</th>
				<th class="bg-white"></th>
			</tr>
		</thead>
		<thead class="column-title">
			<tr>
				<th class="bg-gray-lighter">Músculo</th>
				<th class="bg-gray-lighter">Movimento</th>
                <th class="bg-white" style="width: 100px;">Lado</th>
				@foreach($scale as $row)
					<th class="text-center bg-gray-lighter" style="width: 40px;">
						{{ $row->name }}
					</th>
				@endforeach
				<th class="text-center bg-white"></th>
			</tr>
		</thead>
		
		<?php $group_show = $param_show = true;?>
		@foreach ($testData as $group_name => $group)
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

                        <td class="{{ $divider_data }}">
							{{ $values['side'] }}
						</td>

						@foreach ($scale as $item)
							<td class="{{ $divider_data }} text-center">
								@if ($item->id == $values['scale_id'])
									<i class="fa fa-check"></i>
								@endif
							</td>
						@endforeach

						<td class="{{ $divider_data }} text-center">
							{{ $values['testdate'] }}
						</td>

						<td class="hidden-print text-center" style="width: 26px;">
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
						<td class="hidden-print text-center" style="width: 26px;">
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
