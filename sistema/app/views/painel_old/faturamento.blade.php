
<div class="listagem-faturamento-paciente" style="display: none;">

	<h4>Faturamento</h4>

	@if ($tratamento)

		<div class="row">
			<div class="col-xs-16 col-sm-6 col-md-4 col-lg-4">

				@include('painel_old.faturamento-resumo')
				
				<table class="table table-bordered">
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
				@if($faturamento['total_lancado'] < $faturamento['total'])
					<p>
						<a
							class="btn btn-primary" role="button"
							href="{{ route('financeiroCreateReceber', ['id' => $tratamento->id]) }}"
							><i class="fa fa-plus fa-fw"></i> Lançamento Simples
						</a>
						<a
							class="btn btn-info" role="button"
							href="{{ route('financeiroCreateReceberParcelado', ['id' => $tratamento->id]) }}"
							><i class="fa fa-plus fa-fw"></i> Lançamento Parcelado
						</a>
					</p>
				@elseif($faturamento['total'] == 0)
					<div class="alert alert-warning" role="alert"><strong>Não há valores para lançamento.</strong></div>
				@elseif($faturamento['total_lancado'] == $faturamento['total'])
					<div class="alert alert-success" role="alert"><strong>Lançamento finalizado.</strong></div>
				@else
					<div class="alert alert-warning" role="alert"><strong>A soma de lançamentos excedeu o valor do tratamento.</strong></div>
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
