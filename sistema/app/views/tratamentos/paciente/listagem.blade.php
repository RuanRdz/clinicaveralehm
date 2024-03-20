<h3 style="background: #f9f9f9;">
	Tratamentos
	<a
		class="btn btn-primary btn-xs"
		href="{{ route('tratamentosCreate', ['id' => $paciente->id]) }}"
		title="Novo tratamento"
	><i class="fa fa-plus fa-fw"></i></a>
</h3>
@if (count($listagem) > 0)
	<table class="table valign-middle">
		<tr>
			<td style="width: 80px">Criado em</td>
			<td>Profissional</td>
			<td style="width: 90px">Situação</td>
			<td style="width: 30px"></td>
		</tr>
		@foreach($listagem as $row)
			<?php
			$textColor = '#707070';
			if ($tratamento) :
				if ($row->id == $tratamento->id) :
					$textColor = 'blue';
				endif;
			endif;
			?>
			<tr>
				<td style="color: {{ $textColor }}">
					{{ $row->created_at }}
				</td>
				<td>
					{{ $row->terapeuta->name }}
				</td>
				<td style="background: {{ !is_null($row->tratamentosituacao) ? $row->tratamentosituacao->bg_color : '' }}">
					{{ !is_null($row->tratamentosituacao) ? $row->tratamentosituacao->nome : '' }}
				</td>
				<td style="text-align: right;">
					<a 
						style="color: {{ $textColor }}" 
						href="{{ route('painel', ['id' => $paciente->id, 'id2' => $row->id]) }}">
						<i class="fa fa-arrow-circle-right fa-2x"></i>
					</a>
				</td>
			</tr>
		@endforeach
	</table>
@endif
