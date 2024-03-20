{{ Form::open(array('route' => 'tratamentos', 'class' => 'form', 'role' => 'form')) }}
<div id="modal_filtro_listagem_tratamentos" class="modal ui-front" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-xs-8">
                        <div class="form-group">
                           <div class="input-group">
                               <div class="input-group-addon">De</div>
                               {{ Form::text('data_inicial', timestampToBr($filtro['data_inicial']), ['class' => 'form-control datepicker']) }}
                           </div>
                       </div>
                    </div>
                    <div class="col-xs-8">
                        <div class="form-group">
                            <div class="input-group">
                                <div class="input-group-addon">Até</div>
                                {{ Form::text('data_final', timestampToBr($filtro['data_final']), ['class' => 'form-control datepicker']) }}
                            </div>
                        </div>
                    </div>
                </div>
                @include('workspaces.dropdown-profissional', array('terapeutas' => $terapeutas, 'user_id' => $filtro['terapeuta_id']))
				<div class="form-group">
					<div class="input-group">
			    		<div class="input-group-addon">Tipo</div>
						{{
						Form::select(
							'tratamentotipo_id',
							$tipos,
							$filtro['tratamentotipo_id'],
							['class' => 'form-control']
						)
						}}
					</div>
				</div>
				<div class="form-group">
					<div class="input-group">
			    		<div class="input-group-addon">Situação</div>
						{{
						Form::select(
							'tratamentosituacao_id',
							$situacoes,
							$filtro['tratamentosituacao_id'],
							[
								'class' => 'selectpicker show-tick show-menu-arrow form-control',
								'data-live-search' => 'true'
							]
						)
						}}
					</div>
				</div>
				<div class="form-group">
					<div class="input-group">
			    		<div class="input-group-addon">Lesão</div>
						{{
						Form::select(
							'lesao_id',
							$lesoes,
							$filtro['lesao_id'],
							[
								'class' => 'selectpicker show-tick show-menu-arrow form-control',
								'data-live-search' => 'true'
							]
						)
						}}
					</div>
				</div>
				<div class="form-group">
					<div class="input-group">
			    		<div class="input-group-addon">Membro</div>
						{{
						Form::select(
							'membro_id',
							$membros,
							$filtro['membro_id'],
							[
								'class' => 'selectpicker show-tick show-menu-arrow form-control',
								'data-live-search' => 'true'
							]
						)
						}}
					</div>
				</div>
				<div class="form-group">
					<div class="input-group">
			    		<div class="input-group-addon">Médico</div>
						{{
						Form::select(
							'medico_id',
							$medicos,
							$filtro['medico_id'],
							[
								'class' => 'selectpicker show-tick show-menu-arrow form-control',
								'data-live-search' => 'true'
							]
						)
						}}
					</div>
				</div>
				<div class="form-group">
					<div class="input-group">
			    		<div class="input-group-addon">Convênio</div>
						{{
						Form::select(
							'convenio_id',
							$convenios,
							$filtro['convenio_id'],
							[
								'class' => 'selectpicker show-tick show-menu-arrow form-control',
								'data-live-search' => 'true'
							]
						)
						}}
					</div>
				</div>
            </div>
            <div class="modal-footer">
                @include('layouts.admin.btn-reset-filtro')
                {{ Form::button('Filtrar', ['type' => 'submit', 'class' => 'btn btn-warning']) }}
            </div>
        </div>
    </div>
</div>
{{ Form::close() }}
