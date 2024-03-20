
<div class="form-inline mb-8 p-6 bg-gray-200">
    <div class="mb-8">
        <span class="material-switch mr-6">
            <span class="mr-1 text-lg font-bold" ng-class="{'text-green-600': filtro.tipomovimentacao_entradas, 'text-gray-400': !filtro.tipomovimentacao_entradas}">Entradas</span>
            <input id="tipomovimentacao_entradas" name="tipomovimentacao_entradas" ng-model="filtro.tipomovimentacao_entradas" ng-true-value="1" ng-false-value="0" type="checkbox"/>
            <label for="tipomovimentacao_entradas" class="label-success"></label>
        </span>
        <span class="material-switch mr-6">
            <span class="mr-1 text-lg font-bold" ng-class="{'text-red-600': filtro.tipomovimentacao_saidas, 'text-gray-400': !filtro.tipomovimentacao_saidas}">Saídas</span>
            <input id="tipomovimentacao_saidas" name="tipomovimentacao_saidas" ng-model="filtro.tipomovimentacao_saidas" ng-true-value="1" ng-false-value="0" type="checkbox"/>
            <label for="tipomovimentacao_saidas" class="label-danger"></label>
        </span>
        <span class="dropdown ml-6" ng-if="filtro.show_dropdown_periodo">
            <button class="btn btn-default dropdown-toggle" type="button" id="dropdownFiltroPeriodos" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
                @{{filtro.texto_periodo}}
                <span class="caret"></span>
            </button>
            <ul class="dropdown-menu" aria-labelledby="dropdownFiltroPeriodos">
                <li ng-class="{'active': filtro.periodo_selecionado == 'hoje'}"><a href="#" ng-click="selecionaPeriodo('hoje')">Hoje</a></li>
                <li ng-class="{'active': filtro.periodo_selecionado == 'semana'}"><a href="#" ng-click="selecionaPeriodo('semana')">Esta semana</a></li>
                <li ng-class="{'active': filtro.periodo_selecionado == 'mes'}"><a href="#" ng-click="selecionaPeriodo('mes')">Este mês</a></li>
                <li ng-class="{'active': filtro.periodo_selecionado == '15dias'}"><a href="#" ng-click="selecionaPeriodo('15dias')">Últimos 15 dias</a></li>
                <li ng-class="{'active': filtro.periodo_selecionado == '30dias'}"><a href="#" ng-click="selecionaPeriodo('30dias')">Últimos 30 dias</a></li>
                <li role="separator" class="divider"></li>
                <li ng-class="{'active': filtro.periodo_selecionado == 'input_periodo' || filtro.periodo_selecionado == 'periodo'}"><a href="#" ng-click="selecionaPeriodo('input_periodo')">Escolher período</a></li>
                <li ng-class="{'active': filtro.periodo_selecionado == 'todos'}"><a href="#" ng-click="selecionaPeriodo('todos')">Mostrar todos</a></li>
            </ul>
            <input type="hidden" ng-model="filtro.data_inicial">
            <input type="hidden" ng-model="filtro.data_final">
        </span>
        <div ng-if="!filtro.show_dropdown_periodo" class=" ml-6 inline">
            <div class="form-group">
                <div class="input-group w-48">
                    <div class="input-group-addon bg-green-200">De</div>
                    <input type="text" ng-model="filtro.data_inicial" class="form-control datepicker">
                </div>
            </div>
            <div class="form-group">
                <div class="input-group w-48">
                    <div class="input-group-addon bg-green-200">Até</div>
                    <input type="text" ng-model="filtro.data_final" class="form-control datepicker">
                </div>
            </div>
            <button type="button" ng-click="selecionaPeriodo('periodo')" class="btn btn-default border-none" title="Fechar período">
                <span class="text-gray-400"><i class="fa fa-times"></i></span>
            </button>
        </div>
        <button type="button" ng-click="submitFiltroMovimentacao()" class="btn btn-warning">
            Filtrar
        </button>
    </div>
    <div>
        <button
            type="button"
            class="btn btn-default"
            data-toggle="modal" 
            data-target="#modal_filtro_fluxo"
            title="Mais opçoes"
        >
            <i class="fa fa-filter"></i> Mais filtros
        </button>
        <div class="form-group">
            <div class="input-group">
                <div class="input-group-addon text-black">Conta</div>
                {{ Form::select(
                    'conta_id[]', $filtroOptions['conta'],
                    '',
                    [
                        'ng-model' => 'filtro.conta_id', 
                        'class' => 'selectpicker show-tick show-menu-arrow form-control',
                        'multiple' => 'multiple',
                        'data-live-search' => 'false',
                        'data-selected-text-format' => 'count',
                        'data-size' => '20',
                        'data-header' => 'Selecione',
                        'data-actions-box' => true,
                        'data-select-all-text' => 'Todos',
                        'data-deselect-all-text' => 'Nenhum',
                    ]
                ) }}
            </div>
        </div>
        <div class="form-group">
            <div class="input-group">
                <div class="input-group-addon text-black">Situação</div>
                {{ Form::select(
                    'situacao[]', 
                    $filtroOptions['situacao'], 
                    '', 
                    [
                        'ng-model' => 'filtro.situacao', 
                        'class' => 'selectpicker show-tick show-menu-arrow form-control',
                        'multiple' => 'multiple',
                        'data-live-search' => 'false',
                        'data-selected-text-format' => 'count',
                        'data-size' => '20',
                        'data-header' => 'Selecione',
                        'data-actions-box' => true,
                        'data-select-all-text' => 'Todos',
                        'data-deselect-all-text' => 'Nenhum',
                    ]
                ) }}
            </div>
        </div>
        <div class="form-group">
            <div class="input-group">
                <div class="input-group-addon text-black">Lançamento</div>
                {{ Form::select(
                    'lancamento[]', 
                    $filtroOptions['lancamento'], 
                    '', 
                    [
                        'ng-model' => 'filtro.lancamento', 
                        'class' => 'form-control',
                    ]
                ) }}
            </div>
        </div>
    </div>
</div>

<div id="modal_filtro_fluxo" class="modal ui-front" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <div class="input-group">
                        <div class="input-group-addon bg-yellow-200">Fornecedor</div>
                        {{ Form::text(
                            'fornecedor', 
                            '', 
                            [
                                'id' => 'fornecedor', 
                                'class' => 'form-control',
                                'placeholder' => 'Digite para pesquisar'
                            ]
                        ) }}
                        {{ Former::hidden('fornecedor_id')->id('fornecedor_id') }}
                    </div>
                </div>
                <div class="form-group">
                    <div class="input-group">
                        <div class="input-group-addon bg-green-200">Centro de custos</div>
                        {{ Form::select(
                            'tipodespesa_id[]', $filtroOptions['tipodespesa'],
                            '',
                            [
                                'ng-model' => 'filtro.tipodespesa_id', 
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
                        <div class="input-group-addon bg-teal-200">Plano de contas</div>
                        {{ Form::select(
                            'centrocusto_id[]', $filtroOptions['centrocusto'],
                            '',
                            [
                                'ng-model' => 'filtro.centrocusto_id', 
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
                            '',
                            [
                                'ng-model' => 'filtro.formapagamento_id', 
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
                            '',
                            [
                                'ng-model' => 'filtro.documento_id', 
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
                <div class="form-group">
                    <div class="input-group">
                        <div class="input-group-addon">Cidade</div>
                        {{ Form::select(
                            'cidade_id[]', 
                            $filtroOptions['cidade'], 
                            '', 
                            [
                                'ng-model' => 'filtro.cidade_id', 
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
                <div class="form-group mt-12">
                    <div class="input-group">
                        <div class="input-group-addon">Pesquisar palavra-chave</div>
                        {{ Form::text('busca', '', [
                                'ng-model' => 'filtro.busca', 
                                'class' => 'form-control',
                            ])
                        }}
                    </div>
                    <div class="help-block">Pesquisa palavra-chave nos campos: Descrição/Observação, Código/Guia e Lote</div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Fechar</button>
            </div>
        </div>
    </div>
</div>
