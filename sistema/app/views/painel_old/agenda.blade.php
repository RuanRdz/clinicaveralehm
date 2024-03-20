
<div class="panel panel-default">
	
	<div class="panel-heading">
		<div class="text-primary">
			<strong>Agenda</strong>
            &nbsp;&nbsp;&nbsp;
            <a 
                href="{{ route('agendasEdicaoRapida', ['tratamento_id' => $tratamento->id]) }}" 
                class="btn btn-primary btn-xs btn-edicao-rapida-sessoes">
                Edição
            </a>
		</div>
	</div>
	
	<div class="panel-body">
		
		<table class="table table-sm table-hover table-bordered table-condensed valign-middle table-painel text-center">
			<thead>
				<tr>
					<td style="width:70px;">Sessão</td>
					<td style="width:130px;"><i class="fa fa-calendar"></i> Data</td>
					<td style="width:80px;"><i class="fa fa-clock-o"></i> Horário</td>
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
					<td
						title="{{ !empty(horarios()[$row->fim]) ? 'Encerramento: '.horarios()[$row->fim] : '' }}">
						{{ horarios()[$row->inicio] }}
					</td>
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

	</div>
</div>