


{{ Former::framework('TwitterBootstrap3') }}
{{ Former::populate($convenio) }}
{{ Former::populateField('cidade', $convenio_cidade) }}
{{ Former::vertical_open()
    ->secure()
    ->rules([
        'nome' => 'required',
        'cidade_id' => 'integer',
        'conveniotipo_id' => 'integer',
    ])
    ->attributes(['ng-submit' => "submitForm('$action')"]) }}

    <div class="form-theme-default">
        <div class="form-heading">Convênio</div>
        <div class="form-body">
            <div class="row">
                <div class="col-md-10">
                    {{ Former::text('nome')->label('Nome') }}
                    {{ Former::hidden('cidade_id')->id('cidade_id') }}
                    {{ Former::text('cidade')->id('cidade')->label('Cidade'.$button_fk_cidade)->placeholder('Digite para pesquisar') }}
                    {{ Former::select('conveniotipo_id')->options(Conveniotipo::lists('nome', 'id'))->label('Tipo de convênio'.$button_fk_conveniostipo) }}
                </div>
                <div class="col-md-6">
                    <div class="md:px-10">
                        {{ Former::text('valor')->label('Valor da sessão')->class('form-control')->pattern('([0-9]{1,3}\.)?[0-9]{1,3},[0-9]{2}$')->placeholder('0,00') }}
                        {{ Former::text('limite_sessoes')->label('Limite Sessões')->class('form-control')->help('Quantidade de sessões disponíveis para cada tratamento') }}
                        {{ Former::select('dia_vencimento')->options(Convenio::$diasVencimento)->label('Dia de vencimento')->help('O Dia de vencimento será considerado para lançamento automático do valor total em Contas a receber') }}
                    </div>
                </div>
            </div>
        </div>
        <div class="form-footer">
            <div class="col">
                @if($convenio->id)
                    <a class="confirm-destroy" href="{{ route('conveniosDestroy', array('id' => $convenio->id)) }}">
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
