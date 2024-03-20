
{{ Former::framework('TwitterBootstrap3') }}
{{ Former::populate($cidade) }}
{{ Former::vertical_open()->secure()->rules(Cidade::$rules)->attributes(['ng-submit' => "submitForm('$action')"]) }}
    <div class="form-theme-default">
        <div class="form-heading">Cidade</div>
        <div class="form-body">
            {{ Former::text('nome')->label('Cidade')->id('nova_cidade') }}
            <div class="row">
                <div class="col-xs-16 col-sm-11 col-md-12 col-lg-13">
                    {{ Former::text('estado')->label('Estado') }}
                </div>
                <div class="col-xs-6 col-sm-5 col-md-4 col-lg-3">
                    {{ Former::text('estado_uf')->label('UF') }}
                </div>
            </div>
            {{ Former::text('pais')->label('País') }}
        </div>
        <div class="form-footer">
            <div class="col">
                @if($cidade->id)
                    <a class="confirm-destroy" href="{{ route('cidadesDestroy', array('id' => $cidade->id)) }}">
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
