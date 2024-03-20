
<div class="panel panel-default" style="margin-top: 30px;">
	
	<div class="panel-heading" style="color: #808080;">
		Avaliações (Formato antigo)
	</div>
	
	<div class="panel-body">

		<table 
			class="table table-sm table-bordered valign-middle table-painel"
			style="color: #909090 !important;">
			<tbody style="display: none;">
				<tr>
					<td colspan="2">
					    <a 
					    	href="{{ route('mapeamentosensorialEdit', ['id' => $tratamento->id]) }}"
							style="color: #808080;"
							target="_blank">
					        Mapeamento Sensorial
					    </a>
					</td>
				</tr>
				<tr>
					<td colspan="2">
					    <a 
					    	href="{{ route('tabelaforcaIndex', ['id' => $tratamento->id]) }}"
					    	style="color: #808080;"
							target="_blank">
					        Tabela de Força - Jamar
					    </a>
					</td>
				</tr>
				<tr>
					<td colspan="2">
					    <a 
					    	href="{{ route('testeforcatratamentosIndex', ['id' => $tratamento->id]) }}"
					    	style="color: #808080;"
							target="_blank">
					        Teste de Força Muscular
					    </a>
					</td>
				</tr>
				<tr>
					<td colspan="2">
					    <a 
					    	href="{{ route('amplitudetratamentosIndex', ['id' => $tratamento->id]) }}"
					    	style="color: #808080;"
							target="_blank">
					        Amplitude de Movimento
					    </a>
					</td>
				</tr>
				<tr>
					<td colspan="2">
					    <a 
					    	href="{{ route('avdsEdit', ['id' => $tratamento->id]) }}"
					    	style="color: #808080;"
							target="_blank">
					        AVD's
					    </a>
					</td>
				</tr>
			</tbody>
			<tfoot>
				<tr>
					<th colspan="3">
						<a
							href="{{ route('relatorio', ['id' => $tratamento->id]) }}"
							class="btn btn-sm btn-default btn-block"
							style="color: #808080;"
							target="_blank">
							Relatório
						</a>
					</th>
					<th style="width: 16px">
						<a
							href="{{ route('relatorioEdit', ['id' => $tratamento->id]) }}"
							class="btn btn-sm btn-default btn-block"
							style="color: #808080;"
							target="_blank">
							<i class="fa fa-pencil"></i>
						</a>
					</th>
				</tr>
			</tfoot>
		</table>

	</div>
</div>
