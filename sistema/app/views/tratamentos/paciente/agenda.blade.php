@if ($tratamento)

	<h3 style="background: #f9f9f9;">Agenda</h3>
	<table class="table table-hover table-bordered table-condensed text-center">
		<thead>
			<tr>
				<td style="width:50px;">Sessão</td>
				<td style="width:130px;"><i class="fa fa-calendar"></i> Data</td>
				<td style="width:70px;"><i class="fa fa-clock-o"></i> Inicial</td>
				<td style="width:70px;"><i class="fa fa-clock-o"></i> Final</td>
				<td>Situação</td>
			</tr>
		</thead>
		<tbody class="js-sort-items-agenda">
			<?php
			$idUltimaSessao = $tratamento->obterIdUltimaSessao();
			$i = 1;
			?>
			@foreach ($tratamento->agendas()->orderBy('sessao')->get() as $row)
			<tr
				data-item-id="{{ $row->id }}"
                style="<?php echo $i == 10 ? 'border-bottom: 3px solid #ccc;' : '';?>"
                class="grabbable">
				<td>
					<a
					class="btn {{ $idUltimaSessao == $row->id ? 'btn-info' : 'btn-primary' }} btn-xs btn-agendar"
					href="{{ route('agendasEdit', ['id' => $row->id]) }}"
					>&nbsp;&nbsp;<strong>{{ $row->sessao }}</strong>&nbsp;&nbsp;</a>
				</td>
				<td>
					@if($row->data_sessao)
					{{ diaBr(date('D', strtotime($row->data_sessao))) }},
					{{ $row->data_sessao }}
					@endif
				</td>
				<td>{{ horarios()[$row->inicio] }}</td>
				<td>{{ horarios()[$row->fim] }}</td>
				<td style="background: {{ !is_null($row->agendasituacao) ? $row->agendasituacao->bg_color : '' }}">
					{{ !is_null($row->agendasituacao) ? $row->agendasituacao->nome_sumario : '' }}
				</td>
			</tr>
			<?php
			$i++;
			if ($i == 11) {
				$i = 1;
			}
			?>
			@endforeach
		</tbody>
	</table>
@endif
