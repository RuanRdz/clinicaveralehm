
{{ Former::framework('TwitterBootstrap3') }}
{{ Former::vertical_open()->action(route('financeiroGerarEntrada'))->id('formFinanceiroGerarEntrada')->secure() }}
    {{ Former::hidden('valor')->id('lote_valor') }}
    {{ Former::hidden('desconto_taxa')->id('lote_desconto_taxa') }}
    {{ Former::hidden('juros_multa')->id('lote_juros_multa') }}
    {{ Former::hidden('valor_pago')->id('lote_valor_pago') }}
    <div id="modal_gerar_entrada" class="modal ui-front" tabindex="-1" role="dialog">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                </div>
                <div class="modal-body">
                    <div class="form-theme-default">
                        <div class="form-heading">
                            Gerar Entrada
                        </div>
                        <div class="form-body">
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group required">
                                        <label for="tipo_lancamento" class="control-label">Tipo de Lancamento <sup>*</sup></label>
                                        <div>
                                            <label for="tipo_lancamento_lote" class="cursor-pointer">
                                                <table class="table">
                                                    <tr>
                                                        <td style="width: 30px; vertical-align: middle;">
                                                            <input ng-model="tipo_lancamento" value="lote" id="tipo_lancamento_lote" type="radio" name="tipo_lancamento" checked="checked" required>
                                                        </td>
                                                        <td>
                                                            <div class="font-bold text-lg mb-2">Lote</div> 
                                                            <div class="font-normal text-gray-500"><strong>Soma</strong> os itens selecionados e gera <strong>uma</strong> entrada na Movimentação</div>
                                                        </td>
                                                    </tr>
                                                </table>
                                            </label>
                                        </div>
                                        <div>
                                            <label for="tipo_lancamento_individual" class="cursor-pointer">
                                                <table class="table">
                                                    <tr>
                                                        <td style="width: 30px; vertical-align: middle;">
                                                            <input ng-model="tipo_lancamento" value="individual" id="tipo_lancamento_individual" type="radio" name="tipo_lancamento" required>
                                                        </td>
                                                        <td>
                                                            <div class="font-bold text-lg mb-2">Individual</div> 
                                                            <div class="font-normal text-gray-500">Lança, individualmente, todos os itens selecionados na Movimentação</div>
                                                        </td>
                                                    </tr>
                                                </table>
                                            </label>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-11 col-md-offset-1">
                                    <div ng-if="tipo_lancamento == 'lote'">
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="py-4">
                                                    {{ Former::hidden('tipo')->id('tipo')->value(1)->required() }}
                                                    {{ Former::text('fornecedor')->id('fornecedor')->label('Fornecedor')->placeholder('Digite para pesquisar')->required() }}
                                                    {{ Former::hidden('fornecedor_id')->id('fornecedor_id')->required() }}
                                                    {{ Former::select('conta_id')->options($options['conta'])->label('Conta')->required() }}
                                                    {{ Former::select('centrocusto_id')->options($options['centrocusto'])->label('Plano de contas')->required() }}
                                                    {{ Former::select('tipodepesa_id')->options($options['tipodespesa'])->label('Centro de custos')->required() }}
                                                    <div class="row">
                                                        <div class="col-md-10">
                                                            {{ Former::select('formapagamento_id')->options($options['formapagamento'])->label('Forma de Pagamento')->required() }}
                                                        </div>
                                                        <div class="col-md-6">
                                                            {{ Former::select('documento_id')->options($options['documento'])->label('Documento')->required() }}
                                                        </div>
                                                    </div>
                                                    {{ Former::textarea('descricao')->rows(3)->label('Descrição')->required() }}
                                                    {{ Former::select('finalizar_tratamentos')->options(['' => '', '1' => 'SIM', '0' => 'NÃO'])->label('Deseja finalizar os tratamentos relacionados ao lote?')->required() }}
                                                </div>
                                            </div>
                                            <div class="col-md-4 bg-gray-200">
                                                <div class="p-4">
                                                    {{ Former::text('emissao')->label('Competência')->class('form-control datepicker')->required() }}
                                                    {{ Former::text('vencimento')->label('Vencimento')->class('form-control datepicker')->required() }}
                                                    {{ Former::text('pagamento')->label('Pagamento')->class('form-control datepicker') }}
                                                </div>
                                            </div>
                                        </div>
                                        <div class="text-center">
                                            <table class="table table-bordered text-lg" style="width: 300px;">
                                                <tr>
                                                    <td style="width: 50%;">Valor</td>
                                                    <td class="text-right">@{{total}}</td>
                                                </tr>
                                                <tr>
                                                    <td>Descontos/Taxas</td>
                                                    <td class="text-right">@{{total_desconto_taxa}}</td>
                                                </tr>
                                                <tr>
                                                    <td>Juros/Multa</td>
                                                    <td class="text-right">@{{total_juros_multa}}</td>
                                                </tr>
                                                <tr>
                                                    <td class="font-bold">Valor Pago</td>
                                                    <td class="text-right text-green-700 font-bold">@{{total_pago}}</td>
                                                </tr>
                                            </table>
                                        </div>
                                    </div>
                                    <div ng-if="tipo_lancamento == 'individual'">
                                        <div class="text-center mt-20 text-lg">
                                            <i class="fa fa-check-circle fa-5x text-gray-300"></i>
                                            <div>Lançamentos selecionados: <strong>@{{ ids_lancamentos.length }}</strong></div>
                                        </div>
                                        <!-- nenhum campo é necessário -->
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="form-footer">
                            <div class="col text-right">
                                <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
                                <button type="submit" class="btn btn-primary">Salvar</button>
                            </div>
                        </div>
                    </div>					

                </div>
            </div>
        </div>
    </div>

{{ Former::close() }}
