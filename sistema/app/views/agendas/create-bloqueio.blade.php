
<div class="text-2xl text-gray-600">Bloqueio/Lembrete</div>

{{ Former::framework('TwitterBootstrap3') }}
{{
    Former::vertical_open()
    ->action(route('agendasStoreBloqueio'))
    ->id('form-agenda-bloquear')
    ->rules($rules)
    ->secure()
}}
    <div class="bg-yellow-200 p-4 my-8 shadow">
        <div class="row">
            <div class="col-xs-16 col-sm-16 col-md-16 col-lg-16">
                {{
                Former::textarea('descricao_bloqueio')
                    ->rows(3)
                    ->class('form-control')
                    ->id('descricao_bloqueio')
                    ->label('Descrição')
                }}
            </div>
        </div>
        <div class="row">
            <div class="col-xs-16 col-sm-16 col-md-8 col-lg-8">
                {{
                Former::select('terapeuta_id_bloqueio')
                    ->options($terapeutas)
                    ->class('form-control')
                    ->label('<i class="fa fa-user-md"></i> Profissional')
                }}
            </div>
            <div class="col-xs-16 col-sm-16 col-md-8 col-lg-8">
                {{
                Former::text('autor')
                    ->class('form-control')
                    ->id('autor')
                    ->label('Cadastrado por')
                }}
            </div>
        </div>
        <div class="panel panel-default">
            <div class="panel-body">
                <div class="row">
                    <div class="col-xs-2 col-sm-1" style="padding-top: 17px;">
                        <span 
                            class="btn btn-link js-btn-add-data-bloqueio">
                            <i class="fa fa-plus-circle fa-2x text-success"></i>
                        </span>
                    </div>
                    <div class="col-xs-14 col-sm-15 js-datas-bloqueio">
                        <div class="row">
                            <div class="col-xs-6 col-sm-4 col-md-3 col-lg-3">
                                {{ Former::text('data_sessao[]')
                                    ->class('form-control data_bloqueio datepicker')
                                    ->label('<i class="fa fa-calendar"></i> Data') }}
                            </div>
                            <div class="col-xs-4 col-sm-3 col-md-2 col-lg-2">
                                {{ Former::select('inicio[]')
                                    ->options(horarios())
                                    ->class('form-control')
                                    ->label('<i class="fa fa-clock-o"></i> Inicial') }}
                            </div>
                            <div class="col-xs-4 col-sm-3 col-md-2 col-lg-2">
                                {{ Former::select('fim[]')
                                    ->options(horarios())
                                    ->class('form-control')
                                    ->label('<i class="fa fa-clock-o"></i> Final') }}
                            </div>
                            <div class="col-xs-2 col-sm-6 col-md-9 col-lg-9" style="padding-top: 23px;">
                                <span 
                                    class="btn btn-link js-btn-delete-data-bloqueio"
                                    style="display: none;">
                                    <i class="fa fa-times fa-lg text-red-500"></i>
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="form-group">
            {{ Former::select('bloquear_atendimentos')
                ->options(array(0 => 'Não', 1 => 'Sim'))
                ->class('form-control')
                ->style('width: 100px;')
                ->label('<i class="fa fa-user-md"></i> Bloquear novos atendimentos no horário deste bloqueio')
            }}
        </div>
    </div>
    <div class="text-right">
        <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
        {{ Former::submit('Salvar')->class('btn btn-primary') }}
    </div>
{{ Former::close() }}

