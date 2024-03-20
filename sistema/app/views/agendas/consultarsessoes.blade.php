
@if ($agenda)
	<table class="table table-bordered text-center table-consulta-sessoes valign-middle">
		@foreach ($horarios as $horario)

			<?php 
			$pacientes = null;
			if (isset($agenda[$horario])):
				$pacientes = $agenda[$horario];
			endif;
			?>

			@if ($pacientes)

				<tr>
					<td 
						class="horario"
						style="{{ $horariosDestaque[$horario] ? 'font-weight: bold; background: #fff;' : '' }}">
						{{ $horario }}
					</td>

					@foreach ($pacientes as $info)
						@if ($info['genero'] == 'atendimento')
							
							<?php 
							$cellStyle = 'background: '.$info['bg_color'] == '#FFFFFF' ? '#f0f0f0' : $info['bg_color'].';';
							if($info['limite_de_faltas']) {
								$cellStyle .= $info['limite_de_faltas_css'].' border-width: 2px;';
							}
							?>
							
							<td 
								style="{{ $cellStyle }}" 
								title="atendimento">
								<div
									data-toggle="popover"
									title="{{ $info['nome'] }}"
									data-content="{{ $info['situacao'] }}"
									data-placement="top">
									<?php $complx = $info['complexidade'];?>
									@if ($complx)
										<div 
											class="table-consulta-sessoes-complexidade"
											style="color: {{$complx['color']}}; background: {{$complx['bg_color']}};"
											>{{$complx['grau']}}</div>
									@else
										<div class="table-consulta-sessoes-complexidade">-</div>
									@endif
									@if (!empty($info['fim']))
										<div>
											<i class="fa fa-caret-down"></i>
											<span style="font-size:11px;">{{ $info['fim'] }}</span>
										</div>
									@endif
								</div>
							</td>

						@elseif ($info['genero'] == 'bloqueio')

							<td class="{{ $info['css_class'] }}" title="Bloqueio">
								<div
									data-toggle="popover"
									title="Bloqueio"
									data-content="{{ $info['descricao_bloqueio'] }}"
									data-placement="top">
									<i class="fa fa-ban"></i>
									@if (!empty($info['fim']))
										<div>
											<i class="fa fa-caret-down"></i>
											<span style="font-size:11px;">{{ $info['fim'] }}</span>
										</div>
									@endif
								</div>
							</td>

							@elseif ($info['genero'] == 'agendamento')

								<td class="{{ $info['css_class'] }}" title="Agendamento">
									<div
										data-toggle="popover"
										title="Agendamento"
										data-content="{{ $info['nome_agendamento'] }}"
										data-placement="top">
										<i class="fa fa-calendar"></i>
									</div>
								</td>

						@endif
					@endforeach
				</tr>

			@elseif (substr($horario, -1) == 'h')

				<tr>
					<td 
						class="horario"
						style="{{ $horariosDestaque[$horario] ? 'font-weight: bold; background: #fff;' : '' }}">
						{{ $horario }}
					</td>
					<td class="horario-vazio" colspan="7"></td>
				</tr>
			
			@endif

		@endforeach
	</table>
@else
	<h4>Não há horários agendados nesta data.</h4>
@endif
