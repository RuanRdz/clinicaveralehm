
@include('prontuario.modal')

<div class="panel panel-default">

	<div 
		class="panel-heading"
		style="padding-top: 5px; padding-bottom: 5px;">
		
		<div class="row">
			<div class="col-xs-8">
				<div class="text-primary" style="padding: 6px 0;">
					<strong>Prontuário</strong>
				</div>
			</div>
			<div class="col-xs-8 text-right">
				<a 
					class="btn btn-default btn-sm btn-escrever-prontuario" 
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
			style="max-height: 100px; margin-right: 10px; overflow-y: scroll;">
			
			<table class="table table-sm table-bordered table-hover valign-middle table-painel">
				<tbody>
					@foreach($prontuario as $row)

						<?php $allowActions = $row->checkTimeLimitToUpdate();?>

						<tr>
							<td class="text-center" style="width: 100px;">
								@if($allowActions)
									<a 
										href="{{ route('prontuarioEdit', array('id' => $row->id)) }}"
										title="Editar"
										target="_blank" 
										style="color: #303030;">
										<i class="fa fa-pencil"></i>&nbsp;&nbsp;{{ $row->dataprontuario }}
									</a>
								@else 
									<a 
										href="{{ route('prontuarioShow', array('id' => $row->id)) }}"
										title="Visualizar"
										target="_blank" 
                                        style="color: #303030;"
                                        data-toggle="modal" 
                                        data-target="#modal_prontuario"
                                    >
										<i class="fa fa-eye"></i>&nbsp;&nbsp;{{ $row->dataprontuario }}
									</a>
								@endif
							</td>

							<td>
								{{ $row->terapeuta->name.' '.$row->terapeuta->last_name }}
							</td>
				
							<td class="text-center">
								@if($row->alta)
									<strong class="badge text-success">Alta</strong>
								@endif
							</td>

							<td class="text-center" style="width: 70px;">
								@if($allowActions)
									<a 
										href="{{ route('prontuarioDestroy', array('id' => $row->id)) }}"
										class="btn btn-link confirm-destroy" 
										style="color: #909090;">
										<i class="fa fa-trash fa-fw"></i>
									</a>
								@endif
							</td>
						</tr>
					@endforeach
				</tbody>
			</table>
		</div>

	</div>



	<div class="panel-footer">
		
		<!-- Loaded via Ajax (.btn-escrever-prontuario) -->
		<div class="painel-form-prontuario">
		</div>

	</div>

</div>
