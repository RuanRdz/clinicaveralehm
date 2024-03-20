

{{ Former::framework('TwitterBootstrap3') }}
{{ Former::populate($dados) }}
{{ Former::vertical_open()->secure()->rules(['nome' => 'required', 'ordem' => 'required'])->attributes(['ng-submit' => "submitForm('$action')"]) }}
    <div class="form-theme-default">
        <div class="form-heading">Gabarito para prontuário</div>
        <div class="form-body">
            <div class="row">
                <div class="col-xs-16 col-sm-13">
                    {{ Former::text('nome')->label('Nome') }}
                </div>
                <div class="col-xs-16 col-sm-3">
                    {{ Former::text('ordem')->label('Sequência') }}
                </div>
            </div>
            <div ng-controller="TextosProntuarioFormController">
                <div id="data_conteudo">{{$dados->conteudo}}</div>
                <div class="form-group">
                    <label>Texto do Modelo</label>
                    <textarea 
                        name="conteudo" 
                        ui-tinymce="tinymceOptions"
                        ng-model="tinymceHtml"
                    ></textarea>
                </div>
            </div>
        </div>
        <div class="form-footer">
            <div class="col">
                @if($dados->id)
                    <a class="confirm-destroy" href="{{ route('textosprontuarioDestroy', array('id' => $dados->id)) }}">
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
