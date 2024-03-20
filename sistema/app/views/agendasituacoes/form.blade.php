
{{ Former::framework('TwitterBootstrap3') }}
{{ Former::populate($agendasituacao) }}
{{ Former::vertical_open()->secure()->rules(['nome' => 'required'])->attributes(['ng-submit' => "submitForm('$action')"]) }}
    <div class="form-theme-default">
        <div class="form-heading">Situação Agenda</div>
        <div class="form-body">
            {{ Former::text('nome')->label('Nome na Agenda') }}
            {{ Former::text('nome_sumario')->label('Nome nas Guias') }}
            {{ Former::text('bg_color')->value('#FFFF99')->class('simple_color form-control')->label('Cor') }}
        </div>
        <div class="form-footer">
            <div class="col">
                @if ($agendasituacao->uso_sistema)
                    <span class="text-gray-400" title="Não é possível excluir este registro">
                        <i class="fa fa-lock fa-fw"></i> (Uso reservado do sitema)
                    </span>
                @else
                    @if($agendasituacao->id)
                        <a class="confirm-destroy" href="{{ route('agendasituacoesDestroy', ['id' => $agendasituacao->id]) }}">
                            <i class="fa fa-trash fa-fw"></i> Excluir
                        </a>
                    @endif
                @endif
            </div>
            <div class="col">
                {{ Former::actions('<button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>', Former::submit('Salvar')->class('btn btn-primary'))->class('text-right') }}
            </div>
        </div>
    </div>
{{ Former::close() }}
