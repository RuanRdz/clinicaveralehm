
{{ Former::framework('TwitterBootstrap3') }}
{{ Former::populate($conveniotipo) }}
{{ Former::vertical_open()->secure()->rules(['nome' => 'required'])->attributes(['ng-submit' => "submitForm('$action')"]) }}
    <div class="form-theme-default">
        <div class="form-heading">Tipo de convênio</div>
        <div class="form-body">
            {{ Former::text('nome')->label('Nome') }}
            {{ Former::select('lancamento_automatico')->options([0 => 'Não', 1 => 'Sim'])->label('Lançar saldo automaticamente ao finalizar última sessão')->help('Ao finalizar última sessão, o saldo do tratamento é lançado automaticamente no financeiro') }}
        </div>
        <div class="form-footer">
            <div class="col">
                @if($conveniotipo->id)
                    <a class="confirm-destroy" href="{{ route('conveniotiposDestroy', array('id' => $conveniotipo->id)) }}">
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
