
<div class="report table-responsive">
	<table class="table" style="min-width: 800px;">
		<thead class="title">
			<tr>
				<th class="bg-gray" colspan="5">
					@include('protocols.tests.header-report')
				</th>
			</tr>
		</thead>
		<thead class="column-title">
			<tr>
				<th class="bg-gray-light">Articulação</th>
				<th class="bg-gray-light">Movimento</th>
				<th class="text-center bg-gray-light" style="width: 80px;">Ativo</th>
				<th class="text-center bg-gray-light" style="width: 80px;">Passivo</th>
				<th class="text-center bg-white" style="width: 100px;"></th>
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

						<td class="{{ $divider_data }} text-center">
							{{ $values['degree_active'] }}º
						</td>
						<td class="{{ $divider_data }} text-center">
							{{ $values['degree_passive'] }}º
						</td>
						<td class="{{ $divider_data }} text-center">
							{{ $values['testdate'] }}
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
                                class="confirm-destroy"
                                style="color: #c0c0c0;">
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
