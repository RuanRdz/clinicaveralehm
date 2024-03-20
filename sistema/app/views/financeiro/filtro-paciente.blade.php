{{ Form::open(array('route' => 'financeiroReceber', 'class' => 'form', 'role' => 'form')) }}
<div id="modal_filtro_receber_particular" class="modal ui-front" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-8">
                        <div class="row">
                            <div class="col-xs-8">
                                <div class="form-group">
                                    <div class="input-group">
                                        <div class="input-group-addon bg-red-300">De</div>
                                        {{ Form::text('data_inicial', Session::get('filtro_financeiro.data_inicial'), ['class' => 'form-control datepicker']) }}
                                    </div>
                                </div>
                            </div>
                            <div class="col-xs-8">
                                <div class="form-group">
                                    <div class="input-group">
                                        <div class="input-group-addon bg-red-300">Até</div>
                                        {{ Form::text('data_final', Session::get('filtro_financeiro.data_final'), ['class' => 'form-control datepicker']) }}
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="input-group">
                                <div class="input-group-addon">Tipo de Convênio</div>
                                {{ Form::select(
                                    'conveniotipo_id[]', $filtroOptions['conveniotipo'],
                                    Session::get('filtro_financeiro.conveniotipo_id'),
                                    [
                                        'class' => 'selectpicker show-tick show-menu-arrow form-control',
                                        'multiple' => 'multiple',
                                        'data-live-search' => 'false',
                                        'data-selected-text-format' => 'count',
                                        'data-size' => '20',
                                        'data-header' => 'Selecione',
                                        'data-actions-box' => true,
                                        'data-select-all-text' => 'Marcar todos',
                                        'data-deselect-all-text' => 'Desmarcar todos',
                                    ]
                                ) }}
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="input-group">
                                <div class="input-group-addon">Convênio</div>
                                {{ Form::select(
                                    'convenio_id[]', $filtroOptions['convenio'],
                                    Session::get('filtro_financeiro.convenio_id'),
                                    [
                                        'class' => 'selectpicker show-tick show-menu-arrow form-control',
                                        'multiple' => 'multiple',
                                        'data-live-search' => 'true',
                                        'data-selected-text-format' => 'count',
                                        'data-size' => '20',
                                        'data-header' => 'Selecione',
                                        'data-actions-box' => true,
                                        'data-select-all-text' => 'Marcar todos',
                                        'data-deselect-all-text' => 'Desmarcar todos',
                                    ]
                                ) }}
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="input-group">
                                <div class="input-group-addon">Profissional</div>
                                {{ Form::select(
                                    'terapeuta_id[]', 
                                    $filtroOptions['terapeutas'], 
                                    Session::get('filtro_financeiro.terapeuta_id'), 
                                    [
                                        'class' => 'selectpicker show-tick show-menu-arrow form-control',
                                        
                                        'data-live-search' => 'false',
                                        'data-selected-text-format' => 'count',
                                        'data-size' => '20',
                                        'data-header' => 'Selecione',
                                        'data-actions-box' => true,
                                    ]
                                ) }}
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="input-group">
                                <div class="input-group-addon">Paciente</div>
                                {{ Form::text(
                                    'paciente', 
                                    Session::get('filtro_financeiro.paciente'), 
                                    [
                                        'id' => 'paciente', 
                                        'class' => 'form-control',
                                        'placeholder' => 'Digite para pesquisar'
                                    ]
                                ) }}
                                {{ Former::hidden('paciente_id')->id('paciente_id') }}
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="input-group">
                                <div class="input-group-addon bg-pink-200" title="Pesquisa palavra-chave nos campos: Descrição/Observação, Código/Guia e Lote">Palavra-chave</div>
                                {{ Form::text('busca', Session::get('filtro_financeiro.busca'), ['class' => 'form-control']) }}
                            </div>
                        </div>
                    </div>
                    <div class="col-md-8">
                        <?php /*
                        <div class="form-group">
                            <div class="input-group">
                                <div class="input-group-addon bg-yellow-300">Data</div>
                                {{ Form::select(
                                    'tipo_data', $filtroOptions['tipodata'],
                                    Session::get('filtro_financeiro.tipo_data'),
                                    [
                                        'class' => 'selectpicker show-tick show-menu-arrow form-control',
                                        'data-live-search' => 'false',
                                        'data-size' => '20',
                                        'data-header' => 'Selecione',
                                        'data-actions-box' => true,
                                        'data-select-all-text' => 'Marcar todos',              
                                        'data-deselect-all-text' => 'Desmarcar todos',              
                                    ]
                                ) }}
                            </div>
                        </div>
                        */ ?>
                        <div class="form-group">
                            <div class="input-group">
                                <div class="input-group-addon bg-yellow-300">Situação</div>
                                {{ Form::select(
                                    'situacao[]', 
                                    $filtroOptions['situacao'], 
                                    Session::get('filtro_financeiro.situacao'), 
                                    [
                                        'class' => 'selectpicker show-tick show-menu-arrow form-control',
                                        'multiple' => 'multiple',
                                        'data-live-search' => 'false',
                                        'data-selected-text-format' => 'count',
                                        'data-size' => '20',
                                        'data-header' => 'Selecione',
                                        'data-actions-box' => true,
                                        'data-select-all-text' => 'Marcar todos',
                                        'data-deselect-all-text' => 'Desmarcar todos',
                                    ]
                                ) }}
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="input-group">
                                <div class="input-group-addon bg-red-300">Conta</div>
                                {{ Form::select(
                                    'conta_id[]', $filtroOptions['conta'],
                                    Session::get('filtro_financeiro.conta_id'),
                                    [
                                        'class' => 'selectpicker show-tick show-menu-arrow form-control',
                                        'multiple' => 'multiple',
                                        'data-live-search' => 'false',
                                        'data-selected-text-format' => 'count',
                                        'data-size' => '20',
                                        'data-header' => 'Selecione',
                                        'data-actions-box' => true,
                                        'data-select-all-text' => 'Marcar todos',
                                        'data-deselect-all-text' => 'Desmarcar todos',
                                    ]
                                ) }}
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="input-group">
                                <div class="input-group-addon bg-purple-300">Forma Pgto.</div>
                                {{ Form::select(
                                    'formapagamento_id[]', $filtroOptions['formapagamento'],
                                    Session::get('filtro_financeiro.formapagamento_id'),
                                    [
                                        'class' => 'selectpicker show-tick show-menu-arrow form-control',
                                        'multiple' => 'multiple',
                                        'data-live-search' => 'false',
                                        'data-selected-text-format' => 'count',
                                        'data-size' => '20',
                                        'data-header' => 'Selecione',
                                        'data-actions-box' => true,
                                        'data-select-all-text' => 'Marcar todos',
                                        'data-deselect-all-text' => 'Desmarcar todos',
                                    ]
                                ) }}
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="input-group">
                                <div class="input-group-addon bg-indigo-300">Documento</div>
                                {{ Form::select(
                                    'documento_id[]', $filtroOptions['documento'],
                                    Session::get('filtro_financeiro.documento_id'),
                                    [
                                        'class' => 'selectpicker show-tick show-menu-arrow form-control',
                                        'multiple' => 'multiple',
                                        'data-live-search' => 'false',
                                        'data-selected-text-format' => 'count',
                                        'data-size' => '20',
                                        'data-header' => 'Selecione',
                                        'data-actions-box' => true,
                                        'data-select-all-text' => 'Marcar todos',
                                        'data-deselect-all-text' => 'Desmarcar todos',
                                    ]
                                ) }}
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="input-group">
                                <div class="input-group-addon">Tipo</div>
                                {{ Form::select(
                                    'tipo[]', $filtroOptions['tipo'],
                                    '',
                                    [
                                        'ng-model' => 'filtro.tipo', 
                                        'class' => 'selectpicker show-tick show-menu-arrow form-control',
                                        'multiple' => 'multiple',
                                        'data-live-search' => 'false',
                                        'data-selected-text-format' => 'count',
                                        'data-size' => '20',
                                        'data-header' => 'Selecione',
                                        'data-actions-box' => true,
                                        'data-select-all-text' => 'Marcar todos',
                                        'data-deselect-all-text' => 'Desmarcar todos',
                                    ]
                                ) }}
                            </div>
                        </div>
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
