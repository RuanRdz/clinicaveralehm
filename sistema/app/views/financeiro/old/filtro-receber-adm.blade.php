{{ Form::open(array('route' => 'financeiroReceberAdm', 'class' => 'form', 'role' => 'form')) }}
<div id="modal_filtro_receber_adm" class="modal ui-front" tabindex="-1" role="dialog">
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
                        <div class="input-group-addon bg-pink-200">Palavra-chave Descrição</div>
                        {{Form::text('descricao', Session::get('filtro_financeiro.descricao'), ['class' => 'form-control'])}}
                    </div>
                </div>
                <div class="form-group">
                    <div class="input-group">
                        <div class="input-group-addon bg-yellow-300">Data</div>
                        {{
                        Form::select(
                            'tipo_data', $filtroOptions['tipodata'],
                            Session::get('filtro_financeiro.tipo_data'),
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
                        <div class="input-group-addon bg-yellow-300">Situação</div>
                        {{
                        Form::select(
                            'situacao', $filtroOptions['situacao'],
                            Session::get('filtro_financeiro.situacao'),
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
                        <div class="input-group-addon bg-teal-200">Centro de Custo</div>
                        {{
                        Form::select(
                            'centrocusto_id', $filtroOptions['centrocusto'],
                            Session::get('filtro_financeiro.centrocusto_id'),
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
                        <div class="input-group-addon bg-orange-300">Fornecedor</div>
                        {{
                        Form::select(
                            'fornecedor_id', $filtroOptions['fornecedor'],
                            Session::get('filtro_financeiro.fornecedor_id'),
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
                        <div class="input-group-addon bg-purple-300">Forma Pgto.</div>
                        {{
                        Form::select(
                            'formapagamento_id', $filtroOptions['formapagamento'],
                            Session::get('filtro_financeiro.formapagamento_id'),
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
                        <div class="input-group-addon bg-green-300">Conta</div>
                        {{
                        Form::select(
                            'conta_id', $filtroOptions['conta'],
                            Session::get('filtro_financeiro.conta_id'),
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
                        <div class="input-group-addon">Cidade</div>
                        {{
                        Form::select(
                            'cidade_id', $filtroOptions['cidade'],
                            Session::get('filtro_financeiro.cidade_id'),
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
