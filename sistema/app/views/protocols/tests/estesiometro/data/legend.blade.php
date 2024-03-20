<table class="legend">
	<tbody>
		@foreach($scale as $row)
			<tr>
				<td class="text-center" style="background-color: {{ $row->colorhex }}!important; width: 20px;">
					<strong>{{ $row->code }}</strong>
				</td>
				<td style="color: {{ $row->colorhex != '#ffffff' ? $row->colorhex : '#303030' }}!important;">
					{{ $row->colorname }}
				</td>
				<td>
					{{ $row->description }}
				</td>
			</tr>
		@endforeach
	</tbody>
</table>
