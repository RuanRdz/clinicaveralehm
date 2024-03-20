
{{ Former::framework('TwitterBootstrap3') }}
{{ Former::populate($fornecedor) }}
{{ Former::populateField('cidade', $fornecedor_cidade) }}
{{ Former::vertical_open_for_files()->secure()->rules(['nome' => 'required'])->attributes(['ng-submit' => "submitForm('$action')"]) }}
    <div class="form-theme-default">
        <div class="form-heading">Fornecedor</div>
        <div class="form-body">
            <div class="row">
                <div class="col-xs-16 col-md-8">
                    {{ Former::text('nome')->label('Fornecedor') }}
                    {{ Former::text('razao_social')->label('Razão Social') }}
                    {{ Former::text('cnpj')->label('CNPJ') }}
                    {{ Former::text('inscricao_estadual')->label('Inscrição Estadual') }}
                    {{ Former::text('cpf')->label('CPF') }}
                </div>
                <div class="col-xs-16 col-md-8">
                    {{ Former::textarea('endereco')->rows(2)->label('Endereço') }}
                    {{ Former::text('cidade')->id('cidade')->label('Cidade')->placeholder('Digite para pesquisar') }}
                    {{ Former::hidden('cidade_id')->id('cidade_id') }}
                    <div class="row">
                        <div class="col-xs-16 col-sm-16 col-md-7 col-lg-7">
                            {{ Former::text('telefone')->label('Telefone') }}
                        </div>
                        <div class="col-xs-16 col-sm-16 col-md-9 col-lg-9">
                            <div class="row">
                                <div class="col-xs-10 col-sm-10">
                                    {{ Former::text('celular')->label('Celular') }}
                                </div>
                                <div class="col-xs-6 col-sm-6">
                                    {{ Former::text('operadora_celular')->label('Operadora') }}
                                </div>
                            </div>
                        </div>
                    </div>
                    {{ Former::email('email')->label('E-mail') }}
                </div>
            </div>
        </div>
        <div class="form-footer">
            <div class="col">
                @if($fornecedor->id)
                    <a class="confirm-destroy" href="{{ route('fornecedoresDestroy', array('id' => $fornecedor->id)) }}">
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