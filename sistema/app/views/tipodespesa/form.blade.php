
{{ Former::framework('TwitterBootstrap3') }}
{{ Former::populate($tipodespesa) }}
{{ Former::vertical_open()->secure()->rules(['nome' => 'required'])->attributes(['ng-submit' => "submitForm('$action')"]) }}
    <div class="form-theme-default">
        <div class="form-heading">Centro de custo</div>
        <div class="form-body">
            {{ Former::text('nome')->label('Nome') }}
        </div>
        <div class="form-footer">
            <div class="col">
                @if($tipodespesa->id)
                    <a class="confirm-destroy" href="{{ route('tipodespesaDestroy', array('id' => $tipodespesa->id)) }}">
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
