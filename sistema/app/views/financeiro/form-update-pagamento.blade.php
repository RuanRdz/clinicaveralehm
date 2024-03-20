
{{ Former::framework('TwitterBootstrap3') }}
{{ Former::vertical_open()->action(route('updatePagamento'))->rules(['pagamento' => 'required'])->id('formUpdatePagamento')->autocomplete('off')->secure() }}
    <div class="form-theme-default">
        <div class="form-heading">Informe a data de pagamento para os itens selecionados</div>
        <div class="form-body">
            <div class="row">
                <div class="col-sm-8 col-sm-offset-4 col-md-6 col-md-offset-5 col-lg-4 col-lg-offset-6">
                    {{ Former::text('pagamento')->class('form-control datepicker')->label('<i class="fa fa-calendar"></i> Data de pagamento') }}
                </div>
            </div>
        </div>
        <div class="form-footer">
            <div class="col text-right">
                <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
                {{ Former::submit('Salvar')->class('btn btn-primary') }}
            </div>
        </div>
    </div>					
{{ Former::close() }}
