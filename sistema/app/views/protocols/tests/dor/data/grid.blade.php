
<div class="report table-responsive">
	<table class="table" style="min-width: 800px;">
		<thead class="title">
			<tr>
				<th class="bg-gray" colspan="{{ count($scale) + 1 }}">
					@include('protocols.tests.header-report')
				</th>
			</tr>
		</thead>
		<thead class="column-title">
			<tr>
                <th class="text-center font-normal bg-white" style="width: 10% !important;"></th>
                @foreach($scale as $item)
					<th class="text-center va-top bg-gray-light" style="width: 8.1%">
						<div class="text-center">
							<span class="font-lg" style="line-height: 30px;">{{ $item->score }}</span>
							<br />
							<span class="font-normal font-sm">{{ $item->name }}</span>
						</div>
					</th>
				@endforeach
			</tr>
		</thead>
		<tbody>
			@foreach ($testData as $data)
				<tr>
					<td rowspan="2" class="text-center divider-secondary">
                        {{ $data->testdate }}
                        <br>
                        <span class="font-bold">
                            {{ isset($types[$data->type_id]) ? $types[$data->type_id] : '' }}
                        </span>
                    </td>
					@foreach($scale as $item)
                        <td class="text-center">
                            @if ($data->scale_id == $item->id)
                                <i class="fa fa-circle"></i>
                            @endif
                        </td>
					@endforeach
					<td rowspan="2" class="hidden-print text-center divider-secondary" style="width: 26px;">
                        @if ($data->treatment_id == $treatment->id)
                            <a 
                                href="{{ route($routePath.'.edit', ['id' => $data->id]) }}"
                                style="font-size: 1.5em; color: blue;">
                                <i class="fa fa-pencil"></i>
                            </a>
                        @else 
                            <i 
                                class="fa fa-pencil text-muted" 
                                style="font-size: 1.5em;" 
                                title="Tratamento #{{$data->treatment_id}}">
                            </i>
                        @endif
					</td>
					<td rowspan="2" class="hidden-print text-center divider-secondary" style="width: 26px;">
						<a
                            href="{{ route($routePath.'.destroy', ['id' => $data->id]) }}"
                            class="btn-delete confirm-destroy">
                            <i class="fa fa-times"></i>
                        </a>
					</td>
				</tr>
				<tr>
					<td 
						class="divider-secondary" 
						colspan="{{ count($scale) }}"
						>{{ $data->comment }}</td>
				</tr>
			@endforeach	
		</tbody>
	</table>
</div>
