{{ Form::open(array('route' => 'pacientes', 'class' => 'form', 'role' => 'form')) }}
<div id="modal_filtro_listagem_pacientes" class="modal ui-front" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            </div>
            <div class="modal-body">
				<div class="form-group">
					<div class="input-group">
			    		<div class="input-group-addon">Cidade</div>
						{{
						Form::select(
							'cidade_id',
							$cidades,
							Session::get('filtro_pacientes.cidade_id'),
							[
								'class' => 'form-control',
								'data-live-search' => 'true'
							]
						)
						}}
					</div>
				</div>
				<div class="form-group">
					<div class="input-group">
			    		<div class="input-group-addon">Empresa</div>
						{{
						Form::select(
							'empresa',
							$empresas,
							Session::get('filtro_pacientes.empresa'),
							[
								'class' => 'form-control',
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
