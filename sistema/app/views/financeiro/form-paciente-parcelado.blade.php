
{{ Former::framework('TwitterBootstrap3') }}
{{ Former::populate($financeiro) }}
{{ Former::populateField('tratamento_id', $tratamento->id) }}
{{
    Former::vertical_open()
    ->secure()
    ->attributes(['ng-submit' => "submitForm('$action')", 'autocomplete' => 'off'])
    ->rules([
        'tipo' => 'required',
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
{{ Former::hidden('paciente_id', $tratamento->paciente->id) }}
{{ Former::hidden('codigo') }}
    <div class="form-theme-default">
        <div class="form-heading">
            Lançamento <span class="text-blue-500">Parcelado</span>
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
        <div class="form-body">
            <div class="row">
                <div class="col-xs-16 col-sm-16 col-md-6 col-lg-5">
                    @include('painel.faturamento-resumo')
                </div>
                <div class="col-xs-16 col-sm-16 col-md-10 col-lg-11">
                    <div class="row">
                        <div class="col-md-5">
                            {{ Former::text('emissao')->value(date('d-m-Y'))->label('Competência')->class('form-control datepicker')->pattern('[0-9]{2}-[0-9]{2}-[0-9]{4}$') }}
                        </div>
                        <div class="col-md-5">
                            {{ Former::text('vencimento')->label('Vencimento 1º Parcela')->class('form-control datepicker')->pattern('[0-9]{2}-[0-9]{2}-[0-9]{4}$') }}
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-5">
                            {{ Former::text('parcelamento_quantidade')->label('Número de Parcelas')->class('form-control digits') }}
                        </div>
                        <div class="col-md-5">
                            {{ Former::select('parcelamento_periodo')->options($options['periodosParcelamento'])->label('Intervalo entre Parcelas') }}
                        </div>
                        <div class="col-md-5">
                            {{ Former::text('valor')->label('Valor da Parcela')->class('form-control')->pattern('([0-9]{1,3}\.)?[0-9]{1,3},[0-9]{2}$') }}
                        </div>
                    </div>
                    <div class="row">
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
                    {{ Former::textarea('observacao')->rows(3)->label('Descrição')->help('(A descrição repetirá em todas as parcelas)') }}
                </div>
            </div>
        </div>
        <div class="form-footer">
            <div class="col text-right">
                <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
                @include('financeiro.botao-recibo-form')
                {{ Former::submit('Salvar')->class('btn btn-info') }}
            </div>
        </div>
    </div>
{{ Former::close() }}
