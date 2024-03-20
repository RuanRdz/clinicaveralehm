
{{ Former::framework('TwitterBootstrap3') }}
{{ Former::populate($workspace) }}
{{ Former::populateField('cidade', $workspace_cidade) }}
{{ Former::vertical_open()
    ->secure()
    ->rules([
        'nome' => 'required',
        'cidade_id' => 'integer',
        'cidade' => 'required',
    ])
    ->attributes(['ng-submit' => "submitForm('$action')"]) }}
    <div class="form-theme-default">
        <div class="form-heading">Área de trabalho</div>
        <div class="form-body">
            <div class="row">
                <div class="col-xs-16 col-sm-7 pb-6">
                    {{ Former::text('nome')->label('Nome') }}
                    <div class="row">
                        <div class="col-md-14 col-lg-12">
                            {{ Former::select('visivel')->options(Workspace::$opcoesVisivel)->label('Ativar')->help('A opção "Não", desabilita para todos.') }}
                        </div>
                    </div>
                    {{ Former::hidden('cidade_id')->id('cidade_id') }}
                </div>
                <div class="col-xs-16 col-sm-8 col-sm-offset-1">
                    <div class="mb-2">
                        Usuários autorizados a acessar esta Área de Trabalho
                    </div>
                    <table class="table table-bordered table-striped table-hover valign-middle">
                        <thead>
                            <tr>
                                <th style="width:30px"></th>
                                <th>Usuário</th>
                                <th>Credencial</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach($users as $user):
                                isset($user_workspace[$user->id])
                                    ? $checked = true
                                    : $checked = false;
                                ?>
                                <tr>
                                    <td>{{ Form::checkbox('user_workspace[]', $user->id, $checked) }}</td>
                                    <td>{{ $user->fullName }}</td>
                                    <td>{{ User::$credentials[$user->credential] }}</td>
                                </tr>
                            <?php endforeach;?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <div class="form-footer">
            <div class="col">
                @if($workspace->id)
                    <a class="confirm-destroy" href="{{ route('workspacesDestroy', array('id' => $workspace->id)) }}">
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
