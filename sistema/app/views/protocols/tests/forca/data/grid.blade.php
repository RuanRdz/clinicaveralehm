
<?php 
$x = 0;
$y = 0;
?>

<div class="report table-responsive">
	<table class="table" style="min-width: 800px;">
		<thead class="title">
			<tr>
				<th class="bg-gray" colspan="{{ count($testData['head']) * 2 + 1 }}">
					@include('protocols.tests.header-report')
				</th>
			</tr>
		</thead>
		<thead class="column-title">
			<tr>
				<th class="bg-white"></th>
				@foreach ($testData['head'] as $id => $names)
					<th class="text-center bg-gray-light" colspan="2">
						{{ key($names) }}
					</th>
				@endforeach
			</tr>
		</thead>
		<thead class="column-subtitle">
			<tr>
				<th class="bg-white" rowspan="2" style="width: 100px;"></th>
				@foreach ($testData['head'] as $id => $names)
					@foreach($names as $hands)
                        <?php $x += 2;?>
						<th class="text-center text-red-700 bg-gray-lighter">
							{{ $hands['right'] }}
						</th>
						<th class="text-center bg-gray-lighter">
							{{ $hands['left'] }}
						</th>
					@endforeach
				@endforeach
			</tr>
		</thead>
		<tbody>
			@foreach ($testData['body'] as $testbundle => $arrDates)
                <?php $y = 0;?>
				@foreach ($arrDates as $testdate => $arrValues)
					<tr>
						<td class="text-center">{{ $testdate }}</td>
                        @foreach ($arrValues as $id => $handValue)
                            <?php $y += 2;?>
                            <?php $t_id = $handValue['treatment_id'];?>
							<td class="text-center">{{ $handValue['right'] }}</td>
							<td class="text-center">{{ $handValue['left'] }}</td>
						@endforeach

                        <?php 
                        $z = $x - $y;
                        while ($z > 0) {
                            echo '<td class="text-center">-</td>';
                            $z--;
                        }
                        ?>

						<td class="hidden-print text-center" style="width: 26px;">
                            @if ($t_id == $treatment->id)
                                <a 
                                    href="{{ route($routePath.'.edit', ['id' => $testbundle]) }}"
                                    style="font-size: 1.5em; color: blue;">
                                    <i class="fa fa-pencil"></i>
                                </a>
                            @else 
                                <i 
                                    class="fa fa-pencil text-muted" 
                                    style="font-size: 1.5em;" 
                                    title="Tratamento #{{$t_id}}">
                                </i>
                            @endif
						</td>
						<td class="hidden-print text-center" style="width: 26px;">
							<a
                                href="{{ route($routePath.'.destroy', ['id' => $testbundle]) }}"
                                class="btn-delete confirm-destroy">
                                <i class="fa fa-times"></i>
                            </a>
						</td>
					</tr>
				@endforeach
			@endforeach
		</tbody>
	</table>
</div>
