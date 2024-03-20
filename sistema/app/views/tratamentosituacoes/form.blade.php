
{{ Former::framework('TwitterBootstrap3') }}
{{ Former::populate($tratamentosituacao) }}
{{ Former::vertical_open()->secure()->rules(['nome' => 'required'])->attributes(['ng-submit' => "submitForm('$action')"]) }}
    <div class="form-theme-default">
        <div class="form-heading">Situação do tratamento</div>
        <div class="form-body">
            {{ Former::text('nome')->label('Nome') }}
            {{ Former::text('bg_color')->value('#FFFF99')->class('simple_color form-control')->label('Cor') }}
        </div>
        <div class="form-footer">
            <div class="col">
                @if ($tratamentosituacao->uso_sistema)
                    <span class="text-gray-400" title="Não é possível excluir este registro">
                        <i class="fa fa-lock fa-fw"></i> (Uso reservado do sitema)
                    </span>
                @else
                    @if($tratamentosituacao->id)
                        <a class="confirm-destroy" href="{{ route('tratamentosituacoesDestroy', array('id' => $tratamentosituacao->id)) }}">
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
