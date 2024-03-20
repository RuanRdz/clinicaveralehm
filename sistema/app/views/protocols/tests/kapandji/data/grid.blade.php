
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
				<th class="bg-white" style="width: 10% !important;">
					<img style="width: 100% !important;" src="{{ URL::asset('img/kapandji.png') }}"/>
				</th>
				@foreach($scale as $item)
					<th class="text-center va-top bg-gray-light" style="width: 8.1%">
						<!-- <div class="text-center" style="max-width: 80px;"> -->
							<span class="font-lg" style="line-height: 50px;">
								{{ $item->score }}
							</span>
							<br />
							<span style="font-weight: normal !important;">
								{{ $item->name }}
							</span>
						<!-- </div> -->
					</th>
				@endforeach
			</tr>
		</thead>
		<tbody>
			@foreach ($testData as $data)
				<tr>
					<td class="text-center">
                        {{ $data->testdate }}
                        <br>
                        <span class="font-bold">
                            {{ $sides[$data->side_id] }}
                        </span>
                    </td>
					@foreach($scale as $item)
						@if ($data->scale_id == $item->id)
							<td class="text-center"><i class="fa fa-circle"></i></td>
						@else 
							<td class="text-center"></td>
						@endif
					@endforeach
					<td class="hidden-print text-center" style="width: 26px;">
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
					<td class="hidden-print text-center" style="width: 26px;">
						<a
                            href="{{ route($routePath.'.destroy', ['id' => $data->id]) }}"
                            class="btn-delete confirm-destroy">
                            <i class="fa fa-times"></i>
                        </a>
					</td>
				</tr>
			@endforeach	
		</tbody>
	</table>
</div>
