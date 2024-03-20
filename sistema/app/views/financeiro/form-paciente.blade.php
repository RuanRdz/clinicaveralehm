
<div id="dados_form_lancamento" data-values="{{htmlspecialchars(json_encode($financeiro), ENT_QUOTES, 'UTF-8')}}"></div>

{{ Former::framework('TwitterBootstrap3') }}
{{ Former::populate($financeiro) }}
{{ Former::populateField('tratamento_id', $tratamento->id) }}
{{
    Former::vertical_open()
    ->secure()
    ->attributes(['ng-submit' => "submitForm('$action')", 'autocomplete' => 'off'])
    ->rules([
        'tipo' => 'required',
        'codigo' => 'required',
        'valor' => 'required',
        'emissao' => 'required',
        'vencimento' => 'required',
        'tratamento_id' => 'required',
        'conta_id' => 'required',
        'centrocusto_id' => 'required',
        'tipodespesa_id' => 'required',
        'formapagamento_id' => 'required',
        'documento_id' => 'required',
        'observacao' => 'required',
    ]);
}}
{{ Former::hidden('tratamento_id') }}

    <div class="form-theme-default">
        <div class="form-heading">
            Lançamento <span class="text-green-500">Simples</span>
            <div class="font-bold text-gray-700 text-2xl">
                {{ $tratamento->paciente->nome }}
            </div>
            <div class="text-gray-600">
                <span class="mr-4">Tratamento</span>
                #<strong class="mr-4 text-blue-500">{{ $tratamento->id }}</strong>
                <span>{{ $tratamento->created_at }}</span>
            </div>
            <div>
                <span class="text-gray-600" >Profissional</span>
                <strong class="mr-4 text-blue-500">{{ $tratamento->terapeuta->full_name }}</strong>
            </div>
        </div>

        <div class="row">
            <div class="col-xs-16 col-sm-16 col-md-6 col-lg-5">
                @include('painel.faturamento-resumo')
            </div>
            <div class="col-xs-16 col-sm-16 col-md-10 col-lg-11">
                <div class="form-body">
                    <div class="row">
                        <div class="col-md-4">
                            {{ Former::text('emissao')->value(date('d-m-Y'))->label('Competência/Emissão')->class('form-control datepicker')->pattern('[0-9]{2}-[0-9]{2}-[0-9]{4}$') }}
                        </div>
                        <div class="col-md-4">
                            {{ Former::text('vencimento')->label('Vencimento/Previsão')->class('form-control datepicker')->pattern('[0-9]{2}-[0-9]{2}-[0-9]{4}$') }}
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>Valor <sup>*</sup></label>
                                <input class="form-control" type="text" name="valor" ng-value="'{{$financeiro->valor}}'" ng-model="fin.valor", ng-change="calculaValorPago()" pattern="([0-9]{1,3}\.)?[0-9]{1,3},[0-9]{2}$" required>
                            </div>
                        </div>
                        <div class="col-md-4">
                            {{ Former::text('parcela')->value(1)->label('Parcela') }}
                        </div>
                    </div>
                    <div class="row bg-green-100 shadow pt-2">
                        <div class="col-md-4">
                            @if($financeiro->lote)
                                {{ Former::text('pagamento')->label('Pagamento/Concluído')->class('form-control datepicker')->pattern('[0-9]{2}-[0-9]{2}-[0-9]{4}$')->readonly()->help('LOTE') }}
                            @else 
                                {{ Former::text('pagamento')->label('Pagamento/Concluído')->class('form-control datepicker')->pattern('[0-9]{2}-[0-9]{2}-[0-9]{4}$')->ngModel('fin.pagamento')->ngChange('resetPagamento()') }}
                            @endif
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>Descontos/Taxas <sup>*</sup></label>
                                <input class="form-control" type="text" name="desconto_taxa" ng-value="'{{$financeiro->desconto_taxa}}'" ng-model="fin.desconto_taxa", ng-change="calculaValorPago()" ng-disabled="!fin.pagamento" pattern="([0-9]{1,3}\.)?[0-9]{1,3},[0-9]{2}$" required>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>Juros/Multa <sup>*</sup></label>
                                <input class="form-control" type="text" name="juros_multa" ng-value="'{{$financeiro->juros_multa}}'" ng-model="fin.juros_multa", ng-change="calculaValorPago()" ng-disabled="!fin.pagamento" pattern="([0-9]{1,3}\.)?[0-9]{1,3},[0-9]{2}$" required>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>Valor pago <sup>*</sup></label>
                                <input class="form-control" type="text" name="valor_pago" ng-value="'{{$financeiro->valor_pago}}'" ng-model="fin.valor_pago", ng-change="calculaValor()" ng-disabled="!fin.pagamento" pattern="([0-9]{1,3}\.)?[0-9]{1,3},[0-9]{2}$" required>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="form-body">
                    <div class="row">
                        <div class="col-md-8">
                            {{ Former::text('codigo')->label('Código/Guia')->class('form-control') }}
                        </div>
                        <div class="col-md-8">
                            {{ Former::text('nota_fiscal')->label('Nota Fiscal')->class('form-control') }}
                        </div>
                        <div class="col-md-8">
                            {{ Former::select('conta_id')->options($options['conta'])->label('Conta') }}
                        </div>
                        <div class="col-md-8">
                            {{ Former::select('tipodespesa_id')->options($options['tipodespesa'])->label('Centro de custos') }}
                        </div>
                        <div class="col-md-16">
                            {{ Former::select('centrocusto_id')->options($options['centrocusto'])->label('Plano de contas') }}
                        </div>
                        <div class="col-md-7">
                            {{ Former::select('formapagamento_id')->options($options['formapagamento'])->label('Forma de Pagamento'.$button_fk_formapagamento) }}
                        </div>
                        <div class="col-md-7">
                            {{ Former::select('documento_id')->options($options['documento'])->label('Documento'.$button_fk_documento) }}
                        </div>
                        <div class="col-sm-2">
                            {{ Former::select('tipo')->options($options['tipo'])->label('Tipo') }}
                        </div>
                    </div>
                    {{ Former::textarea('observacao')->rows(3)->label('Descrição') }}
                </div>
            </div>
        </div>

        <div class="form-footer">
            <div class="col">
                @if($financeiro->id)
                    <a class="btn btn-link confirm-destroy" href="{{ route('financeiroDestroy', array('id' => $financeiro->id)) }}">
                        <i class="fa fa-trash"></i> Excluir
                    </a>
                @endif
            </div>
            <div class="col text-right">
                <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
                @include('financeiro.botao-recibo-form')
                {{ Former::submit('Salvar')->class('btn btn-primary') }}
            </div>
        </div>
    </div>
{{ Former::close() }}
