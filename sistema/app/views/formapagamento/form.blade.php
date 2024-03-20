
{{ Former::framework('TwitterBootstrap3') }}
{{ Former::populate($formapagamento) }}
{{ Former::vertical_open()->secure()->rules(['nome' => 'required'])->attributes(['ng-submit' => "submitForm('$action')"]) }}
    <div class="form-theme-default">
        <div class="form-heading">Forma de pagamento</div>
        <div class="form-body">
            {{ Former::text('nome')->label('Nome') }}
            <div class="row">
                <div class="col-sm-6 col-md-4">
                    {{ Former::text('taxa')->label('Taxa')->class('form-control input-taxa')->placeholder('0.00%') }}
                </div>
            </div>
        </div>
        <div class="form-footer">
            <div class="col">
                @if($formapagamento->id)
                    <a class="confirm-destroy" href="{{ route('formapagamentoDestroy', array('id' => $formapagamento->id)) }}">
                        <i class="fa fa-trash fa-fw"></i> Excluir
                    </a>
                @endif
            </div>
            <div class="col">
                {{ Former::actions('<button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>', Former::submit('Salvar')->class('btn btn-primary'))->class('text-right') }}
            </div>
        </div>
    </div>
{{ Former::close() }}
