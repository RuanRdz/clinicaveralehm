<div class="listagem-faturamento-paciente" style="display: none;">

	<h4 style="background: #f9f9f9;">Faturamento</h4>

	@if ($tratamento)

		<div class="row">
			<div class="col-xs-16 col-sm-6 col-md-4 col-lg-4">
				<table class="table table-bordered">
					@if (!is_null($tratamento->convenio))
						<tr>
							<td class="text-right" style="background:#f4f4f4;">Convênio</td>
							<td colspan="2" style="background:#f0f0f0;">
								<span style=" font-size: 10px;">
									<strong>{{ $tratamento->convenio->nome }}</strong>
									<br />
									@if ($tratamento->convenio->cidade)
										{{
											$tratamento->convenio->cidade->nome.' / '.
											$tratamento->convenio->cidade->estado_uf
										}}
									@endif
								</span>
								<br />
								Dia de Vencimento:
								@if ($tratamento->convenio->dia_vencimento)
									<strong>{{ $tratamento->convenio->dia_vencimento }}</strong>
								@else
									<strong>Nenhum</strong>
								@endif
							</td>
						</tr>
						<tr class="hide">
							<td colspan="2" class="text-right" style="background:#f4f4f4;">Valor por Sessão</td>
							<td style="background:#f0f0f0;">{{ $tratamento->convenio->valor }}</td>
						</tr>
					@endif

					<tr>
						<td colspan="2" class="text-right" style="background:#f4f4f4;">
							Valor do tratamento
						</td>
						<td style="background:#e3e3e3;">
							{{ $total }}
						</td>
					</tr>
					<tr>
						<td colspan="2" class="text-right"style="background:#f9f9f9;">
							Total lançado
						</td>
						<td style="background:#f0f0f0;">
							{{ $total_lancado }}
						</td>
					</tr>
					<tr>
						<td colspan="2" class="text-right"style="background:#f9f9f9;">
							Saldo a lançar
						</td>
						<td style="background:#f0f0f0;">
							{{ $saldo_a_lancar }}
						</td>
					</tr>
					<tr>
						<td colspan="2" class="text-right" style="background:#f9f9f9;">
							Lançamentos a pagar
						</td>
						<td style="background:#f0f0f0;">
							@if ($lancamentos_a_pagar == 0)
								<strong class="text-success">{{ $lancamentos_a_pagar }}</strong>
							@else
								<strong class="text-danger">{{ $lancamentos_a_pagar }}</strong>
							@endif
						</td>
					</tr>
					<tr>
						<td colspan="2" class="text-right"style="background:#f9f9f9;">
							Total pago
						</td>
						<td style="background:#f0f0f0;">
							<strong class="text-success">{{ $total_pago }}</strong>
						</td>
					</tr>
					<tr>
						<td class="text-center" colspan="3">Legenda</td>
					</tr>
					<tr>
						<td style="width:33%" class="text-center">Aberto</td>
						<td style="width:33%" class="text-center bg-success">Pago</td>
						<td style="width:33%" class="text-center bg-danger">Vencido</td>
					</tr>
				</table>
			</div>

			<div class="col-xs-16 col-sm-16 col-md-12 col-lg-12">
				@if($total_lancado < $total)
					<p>
						<a
							class="btn btn-primary btn-xs" role="button"
							href="{{ route('financeiroCreateReceber', ['id' => $tratamento->id]) }}"
							><i class="fa fa-plus fa-fw"></i> Lançamento Simples
						</a>
						<a
							class="btn btn-info btn-xs" role="button"
							href="{{ route('financeiroCreateReceberParcelado', ['id' => $tratamento->id]) }}"
							><i class="fa fa-plus fa-fw"></i> Lançamento Parcelado
						</a>
					</p>
				@elseif($total == 0)
					<div class="alert alert-warning" role="alert"><strong>Não há valores para lançamento.</strong></div>
				@elseif($total_lancado == $total)
					<div class="alert alert-success" role="alert"><strong>Lançamento finalizado.</strong></div>
				@else
					<div class="alert alert-danger" role="alert"><strong>A soma de lançamentos excedeu o valor do tratamento.</strong></div>
				@endif

				@if(count($dados = $tratamento->financeiro()->with('documento')->get()) > 0)

					<table class="table table-condensed table-bordered valign-middle" style="font-size:11px;">
						<thead>
							<tr>
								<th style="width:25px;">
								</th>
								<th style="width:80px;">Emissão</th>
								<th style="width:80px;">Vencimento</th>
								<th style="width:80px;">Pagamento</th>
								<th style="width:60px;">Valor</th>
								<th style="width:90px;">Documento</th>
								<th style="width:90px;">Forma de Pgto.</th>
								<th style="width:140px;">Conta</th>
								<th>Observação</th>
								<th style="width:20px;"></th>
							</tr>
						</thead>
						<tbody>
							@foreach ($dados as $row)

								@if ($row->pagamento)
									<tr class="bg-success">
								@elseif (!$row->pagamento && (brDateToDatabase($row->vencimento) < date('Y-m-d')))
									<tr class="bg-danger">
								@else
									<tr>
								@endif
									<td class="text-center">
										<a
											href="{{ route('financeiroEditReceber', ['id' => $row->id]) }}"
										><i class="fa fa-pencil"></i></a>
									</td>
									<td>{{ $row->emissao }}</td>
									<td>{{ $row->vencimento }}</td>
									<td>{{ $row->pagamento }}</td>
									<td>{{ $row->valor }}</td>
									<td>{{ !is_null($row->documento) ? $row->documento->nome : '' }}</td>
									<td>{{ !is_null($row->formapagamento) ? $row->formapagamento->nome : '' }}</td>
									<td>{{ !is_null($row->conta) ? $row->conta->nome : '' }}</td>
									<td>{{ $row->observacao }}</td>
									<td class="text-center">
										<a
											href="{{ route('financeiroDestroy', ['id' => $row->id]) }}"
											class="confirm-destroy"
										><i class="fa fa-trash"></i></a>
									</td>
								</tr>
							@endforeach
						</tbody>
					</table>

				@else

					<p>Nenhum lançamento realizado para este tratamento.</p>

				@endif

			</div>
		</div>
	@endif
</div>
