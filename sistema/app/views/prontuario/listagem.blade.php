
<div class="panel panel-success">
	<div class="panel-heading">
		<div class="row">
			<div class="col-xs-8">
				<h4>Prontuário</h4>
			</div>
			<div class="col-xs-8 text-right">
				<a 
					class="btn btn-primary" 
					title="Escrever" 
					href="{{ route('prontuarioCreate', array('paciente_id' => $paciente->id)) }}">
					<i class="fa fa-pencil fa-fw"></i> Escrever
				</a>
			</div>
		</div>
	</div>
	<div class="panel-body">
		<div 
			class="listagem_prontuario" 
			style="height: 250px; max-height: 250px; margin-right: 10px; overflow-y: scroll;">
			<table class="table table-striped table-hover valign-middle">
				<thead>
					<tr>
						<th style="width: 40%;" class="text-center">Data</th>
						<th class="text-center">
							<i 
								class="fa fa-info-circle fa-lg text-muted" 
								title="Item do Prontuário é liberado para alterações nas primeiras 48h após registro."></i>
						</th>
					</tr>
				</thead>
				<tbody>
					@foreach($prontuario as $row)
						<?php $allowActions = $row->checkTimeLimitToUpdate();?>
						<tr>
							<td class="text-center">
								@if($allowActions)
									<a 
										class="btn btn-link"
										href="{{ route('prontuarioEdit', array('id' => $row->id)) }}"
										title="Editar">
										<i class="fa fa-pencil"></i>&nbsp;&nbsp;{{ $row->dataprontuario }}
									</a>
								@else 
									<a 
										class="btn btn-link"
										href="{{ route('prontuarioShow', array('id' => $row->id)) }}"
										title="Visualizar"
                                        data-toggle="modal" 
                                        data-target="#modal_prontuario"
                                    >
										<i class="fa fa-eye"></i>&nbsp;&nbsp;{{ $row->dataprontuario }}
									</a>
								@endif
							</td>
							<td class="text-center">
								@if($allowActions)
									<a 
										class="btn btn-link confirm-destroy" 
										href="{{ route('prontuarioDestroy', array('id' => $row->id)) }}">
										<i class="fa fa-trash fa-fw fa-lg"></i>
									</a>
								@endif
							</td>
						</tr>
					@endforeach
				</tbody>
			</table>
		</div>
	</div>
</div>
