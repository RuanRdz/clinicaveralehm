
{{ Former::framework('TwitterBootstrap3') }}
{{ Former::populate($conta) }}
{{ Former::vertical_open()->secure()->rules($rules)->attributes(['ng-submit' => "submitForm('$action')"]) }}
    <div class="form-theme-default">
        <div class="form-heading">Conta</div>
        <div class="form-body">
            <div class="row">
                <div class="col-sm-10 col-md-9">
                    {{ Former::text('nome')->label('Nome') }}
                    {{ Former::select('banco_id')->options(Banco::lists('nome', 'id'))->label('Banco') }}
                    {{ Former::text('agencia')->label('Agência') }}
                    {{ Former::text('conta')->label('Nº da conta') }}
                </div>
                <div class="col-sm-6 col-md-6 col-md-offset-1">
                    <div class="bg-white shadow p-4 h-full">
                        @if(!$conta->id)
                            {{ Former::text('valor_saldo')->label('Saldo Inicial')->class('form-control input-moeda')->pattern('([0-9]{1,3}\.)?[0-9]{1,3},[0-9]{2}$') }}
                            {{ Former::text('data_saldo')->label('Data do Saldo')->class('form-control datepicker')->pattern('[0-9]{2}-[0-9]{2}-[0-9]{4}$') }}
                        @else 
                            {{ Former::text('valor_saldo')->label('Saldo Inicial')->readonly()->class('form-control input-moeda') }}
                            {{ Former::text('data_saldo')->label('Data do Saldo')->readonly()->class('form-control datepicker') }}
                        @endif
                    </div>
                </div>
            </div>
        </div>
        <div class="form-footer">
            <div class="col">
                @if($conta->id)
                    <a class="confirm-destroy" href="{{ route('contasDestroy', array('id' => $conta->id)) }}">
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
