
<div class="text-2xl text-gray-600">Pré-agendamento</div>

{{ Former::framework('TwitterBootstrap3') }}
{{ Former::populate($dados) }}
{{
    Former::vertical_open()
    ->action(route('agendasUpdateAgendamento', array('id' => $dados->id)))
    ->rules($rules)
    ->id('form-agenda-editar-agendamento')
    ->secure()
}}
    <div class="bg-blue-200 p-4 my-8 shadow">
        <div class="row">
            <div class="col-xs-16 col-sm-8 col-md-3 col-lg-3">
                {{
                Former::text('data_sessao')
                    ->class('form-control datepicker')
                    ->id('data_agendamento')
                    ->label('<i class="fa fa-calendar"></i> Data')
                }}
            </div>
            <div class="col-xs-16 col-sm-8 col-md-3 col-lg-3">
                {{
                Former::select('inicio')
                    ->options(horarios())
                    ->class('form-control')
                    ->label('<i class="fa fa-clock-o"></i> Horário')
                }}
            </div>
            <div class="col-xs-16 col-sm-8 col-md-5 col-lg-5">
                {{ Former::select('terapeuta_id_agendamento')
                    ->options($terapeutas)
                    ->class('form-control')
                    ->label('<i class="fa fa-user-md"></i> Profissional') }}
            </div>
            <div class="col-xs-16 col-sm-8 col-md-5 col-lg-5">
                {{
                Former::text('autor')
                    ->class('form-control')
                    ->id('autor')
                    ->label('Cadastrado por')
                }}
            </div>
            <div class="col-xs-16 col-sm-16 col-md-10 col-lg-10">
                {{
                Former::text('nome_agendamento')
                    ->class('form-control')
                    ->id('nome_agendamento')
                    ->label('<i class="fa fa-user"></i> Nome')
                }}
            </div>
            <div class="col-xs-16 col-sm-16 col-md-6 col-lg-6">
                {{
                Former::text('telefone_agendamento')
                    ->class('form-control')
                    ->id('telefone_agendamento')
                    ->label('<i class="fa fa-phone"></i> Telefones')
                }}
            </div>
            <div class="col-xs-16 col-sm-16 col-md-6 col-lg-6">
                {{
                Former::text('doenca_agendamento')
                    ->class('form-control')
                    ->id('doenca_agendamento')
                    ->label('<i class="fa fa-stethoscope"></i> Doença')
                }}
            </div>
            <div class="col-xs-16 col-sm-16 col-md-6 col-lg-6">
                {{
                Former::text('medico_agendamento')
                    ->class('form-control')
                    ->id('medico_agendamento')
                    ->label('<i class="fa fa-user-md"></i> Médico')
                }}
            </div>
            <div class="col-xs-16 col-sm-16 col-md-4 col-lg-4">
                {{
                Former::text('convenio_agendamento')
                    ->class('form-control')
                    ->id('convenio_agendamento')
                    ->label('<i class="fa fa-hospital-o"></i> Convênio')
                }}
            </div>
        </div>
        <div class="row">
            <div class="col-xs-16 col-sm-16 col-md-16 col-lg-16">
                {{
                Former::textarea('observacao_agendamento')
                    ->rows(3)
                    ->class('form-control')
                    ->id('observacao_agendamento')
                    ->label('Observação')
                }}
            </div>
        </div>
    </div>
    <div class="text-right">
        <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
        {{ Former::submit('Salvar')->class('btn btn-primary') }}
    </div>
{{ Former::close() }}
