
{{ Former::framework('TwitterBootstrap3') }}
{{ Former::populate($medico) }}
{{ Former::vertical_open()->secure()->rules(['nome' => 'required'])->attributes(['ng-submit' => "submitForm('$action')"]) }}
    <div class="form-theme-default">
        <div class="form-heading">Médico</div>
        <div class="form-body">
            {{ Former::text('nome')->label('Nome') }}
            <div class="row">
                <div class="col-xs-16 col-sm-8">
                    {{ Former::text('cpf')->label('CPF') }}
                </div>
                <div class="col-xs-16 col-sm-8">
                    {{ Former::text('crm')->label('CRM') }}
                </div>
            </div>
            {{ Former::text('telefone')->label('Telefones') }}
            {{ Former::textarea('endereco')->label('Endereço')->rows(2) }}
        </div>
        <div class="form-footer">
            <div class="col">
                @if($medico->id)
                    <a class="confirm-destroy" href="{{ route('medicosDestroy', array('id' => $medico->id)) }}">
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
