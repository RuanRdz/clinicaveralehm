
<div class="text-2xl text-gray-600">Bloqueio/Lembrete</div>

{{ Former::framework('TwitterBootstrap3') }}
{{ Former::populate($dados) }}
{{
    Former::vertical_open()
    ->action(route('agendasUpdateBloqueio', array('id' => $dados->id)))
    ->rules($rules)
    ->id('form-agenda-editar-bloqueio')
    ->secure()
}}
    <div class="bg-yellow-200 p-4 my-8 shadow">
        <div class="row">
            <div class="col-xs-16 col-sm-16 col-md-16 col-lg-16">
                {{
                Former::textarea('descricao_bloqueio')
                    ->rows(2)
                    ->class('form-control')
                    ->id('descricao_bloqueio')
                    ->label('Descrição')
                }}
            </div>
        </div>
        <div class="row">
            <div class="col-xs-10 col-sm-6 col-md-4 col-lg-4">
                {{
                Former::text('data_sessao')
                    ->class('form-control datepicker')
                    ->id('data_bloqueio')
                    ->label('<i class="fa fa-calendar"></i> Data')
                }}
            </div>
            <div class="col-xs-7 col-sm-5 col-md-3 col-lg-3">
                {{
                Former::select('inicio')
                    ->options(horarios())
                    ->class('form-control')
                    ->label('<i class="fa fa-clock-o"></i> Inicial')
                }}
            </div>
            <div class="col-xs-7 col-sm-5 col-md-3 col-lg-3">
                {{
                Former::select('fim')
                    ->options(horarios())
                    ->class('form-control')
                    ->label('<i class="fa fa-clock-o"></i> Final')
                }}
            </div>
            <div class="col-xs-9 col-sm-9 col-md-6 col-lg-6">
                {{
                Former::select('terapeuta_id_bloqueio')
                    ->options($terapeutas)
                    ->class('form-control')
                    ->label('<i class="fa fa-user-md"></i> Profissional')
                }}
            </div>
        </div>
        <div class="row">
            <div class="col-xs-16 col-sm-16 col-md-16 col-lg-16">
                {{
                Former::text('autor')
                    ->class('form-control')
                    ->id('autor')
                    ->label('Cadastrado por')
                }}
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
