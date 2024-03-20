
<div id="dados_form_lancamento" data-values="{{htmlspecialchars(json_encode($financeiro), ENT_QUOTES, 'UTF-8')}}"></div>

{{ Former::framework('TwitterBootstrap3') }}
{{ Former::populate($financeiro) }}
{{ Former::populateField('fornecedor', $fornecedor) }}
{{ Former::populateField('cidade', $cidade) }}
{{
    Former::vertical_open()
    ->secure()
    ->attributes(['ng-submit' => "submitForm('$action')", 'autocomplete' => 'off'])
    ->rules([
        'tipo' => 'required',
        'codigo' => 'required',
        'emissao' => 'required',
        'vencimento' => 'required',
        'fornecedor' => 'required',
        'conta_id' => 'required',
        'centrocusto_id' => 'required',
        'tipodespesa_id' => 'required',
        'formapagamento_id' => 'required',
        'documento_id' => 'required',
        'descricao' => 'required',
        'parcelamento_quantidade' => 'integer',
    ])
}}
    <div class="form-theme-default">
        <div class="form-heading">
            <span class="text-green-600">Recebimento</span>
        </div>
        <div class="form-body">
            {{ Former::text('fornecedor')->id('fornecedor')->label('Fornecedor'.$button_fk_fornecedor)->placeholder('Digite para pesquisar') }}
            {{ Former::hidden('fornecedor_id')->id('fornecedor_id') }}
            <div class="row">
                <div class="col-md-10">
                    {{ Former::text('codigo')->label('Código') }}
                </div>
                <div class="col-md-6">
                    {{ Former::text('nota_fiscal')->label('Nº Nota Fiscal') }}
                </div>
            </div>
            {{ Former::text('descricao')->label('Descrição do item (Produto/Serviço)') }}
            <div class="row">
                <div class="col-md-8">
                    {{ Former::select('conta_id')->options($options['conta'])->label('Conta') }}
                </div>
                <div class="col-md-8">
                    {{ Former::select('centrocusto_id')->options($options['centrocusto'])->label('Plano de contas') }}
                </div>
            </div>
            <div class="row">
                <div class="col-sm-6">
                    {{ Former::select('formapagamento_id')->options($options['formapagamento'])->label('Forma de Pagamento'.$button_fk_formapagamento) }}
                </div>
                <div class="col-sm-4">
                    {{ Former::select('documento_id')->options($options['documento'])->label('Documento'.$button_fk_documento) }}
                </div>
                <div class="col-sm-4">
                    {{ Former::select('tipodespesa_id')->options($options['tipodespesa'])->label('Centro de custo') }}
                </div>
                <div class="col-sm-2">
                    {{ Former::select('tipo')->options($options['tipo'])->label('Tipo') }}
                </div>
            </div>
            <div class="row">
                <div class="col-sm-5">
                    {{ Former::text('cidade')->id('cidade')->label('Cidade')->placeholder('Digite para pesquisar') }}
                    {{ Former::hidden('cidade_id')->id('cidade_id') }}
                </div>
            </div>
        </div>
        <div class="form-body">
            <div class="row">
                <div class="col-md-4">
                    {{ Former::text('emissao')->value(date('d-m-Y'))->label('Competência/Emissão')->class('form-control datepicker')->pattern('[0-9]{2}-[0-9]{2}-[0-9]{4}$') }}
                </div>
                <div class="col-md-4">
                    {{ Former::text('vencimento')->label('Vencimento/Previsão')->class('form-control datepicker')->pattern('[0-9]{2}-[0-9]{2}-[0-9]{4}$') }}
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <label>Valor <sup>*</sup></label>
                        <input class="form-control" type="text" name="valor" ng-value="'{{$financeiro->valor}}'" ng-model="fin.valor", ng-change="calculaValorPago()" pattern="([0-9]{1,3}\.)?[0-9]{1,3},[0-9]{2}$" required>
                    </div>
                </div>
                <div class="col-md-2">
                    {{ Former::text('parcela')->value(1)->label('Parcela') }}
                </div>
            </div>
            <div class="row bg-green-100 shadow pt-2">
                <div class="col-md-4">
                    {{ Former::text('pagamento')->label('Pagamento/Concluído')->class('form-control datepicker')->pattern('[0-9]{2}-[0-9]{2}-[0-9]{4}$')->ngModel('fin.pagamento')->ngChange('resetPagamento()') }}
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <label>Descontos/Taxas <sup>*</sup></label>
                        <input class="form-control" type="text" name="desconto_taxa" ng-value="'{{$financeiro->desconto_taxa}}'" ng-model="fin.desconto_taxa", ng-change="calculaValorPago()" ng-disabled="!fin.pagamento" pattern="([0-9]{1,3}\.)?[0-9]{1,3},[0-9]{2}$" required>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <label>Juros/Multa <sup>*</sup></label>
                        <input class="form-control" type="text" name="juros_multa" ng-value="'{{$financeiro->juros_multa}}'" ng-model="fin.juros_multa", ng-change="calculaValorPago()" ng-disabled="!fin.pagamento" pattern="([0-9]{1,3}\.)?[0-9]{1,3},[0-9]{2}$" required>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <label>Valor pago <sup>*</sup></label>
                        <input class="form-control" type="text" name="valor_pago" ng-value="'{{$financeiro->valor_pago}}'" ng-model="fin.valor_pago", ng-change="calculaValor()" ng-disabled="!fin.pagamento" pattern="([0-9]{1,3}\.)?[0-9]{1,3},[0-9]{2}$" required>
                    </div>
                </div>
            </div>
        </div>
        @if(! $financeiro->id)
            <div class="form-body">
                <div class="mb-4">
                    <div class="checkbox">
                        <label>
                            <input type="checkbox" ng-model="check_repetir" ng-true-value="1" ng-false-value="0">
                            <strong>Repetir</strong>
                        </label>
                    </div>
                </div>
                <div class="row" ng-if="check_repetir">
                    <div class="col-md-3">
                        {{ Former::text('parcelamento_quantidade')->label('Número de Parcelas')->class('form-control digits')->pattern('[0-9]+$') }}
                    </div>
                    <div class="col-md-4">
                        {{ Former::select('parcelamento_periodo')->options($options['periodosParcelamento'])->label('Intervalo entre Parcelas') }}
                    </div>
                    <div class="col-xs-3 col-sm-3 col-md-3 col-lg-3" style="padding-top: 22px;">
                        <a
                            href="{{ route('financeiroSimularParcelamento') }}"
                            id="btn_simular_parcelamento"
                            class="btn btn-default btn-block bg-blue-200 border-blue-300 text-blue-600">
                            Simular
                        </a>
                    </div>
                    <div class="col-xs-16">
                        <div id="display_simulacao_parcelamento"></div>
                    </div>
                </div>
            </div>
        @endif
        <div class="form-footer">
            <div class="col">
                <!-- empty -->
            </div>
            <div class="col text-right">
                <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
                @include('financeiro.botao-recibo-form')
                {{ Former::submit('Salvar')->class('btn btn-primary') }}
            </div>
        </div>
    </div>
{{ Former::close() }}
