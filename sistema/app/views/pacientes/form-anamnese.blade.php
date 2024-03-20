
@if (User::allowedCredentials([20], true))

	{{ Former::framework('TwitterBootstrap3') }}
	{{ Former::populate($paciente) }}
	{{
		Former::vertical_open_for_files()
		->action(route('pacientesUpdateAnamnese', array('id' => $paciente->id)))
        ->id('form-paciente-anamnese')
		->method('POST')
        ->autocomplete('off')
		->secure()
	}}

        <div>
            <ul class="nav nav-tabs" role="tablist">
                <li role="presentation" class="active">
                    <a href="#tab_saude" aria-controls="tab_saude" role="tab" data-toggle="tab">
                        <strong class="text-primary">SAÚDE</strong>
                    </a>
                </li>
                <li role="presentation">
                    <a href="#tab_complementos" aria-controls="tab_complementos" role="tab" data-toggle="tab">
                        <strong class="text-primary">INFORMAÇÕES COMPLEMENTARES</strong>
                    </a>
                </li>
                <li role="presentation">
                    <!-- <a href>Salvar</a> -->
                    <button type="submit" class="btn btn-primary" style="margin-left: 10px; margin-top: 6px; padding-top: 3px; padding-bottom: 3px;">
                        Salvar
                    </button>
                </li>
            </ul>
            <div class="tab-content">
                <!-- Saúde -->
                <div role="tabpanel" class="tab-pane active" id="tab_saude">
                    <div class="panel panel-default" style="border-top: none;">
                        <div class="panel-body" style="padding-top: 30px;">
                            <div class="row">
                                <div class="col-xs-8 col-sm-8 col-md-8 col-lg-8">
                                    {{ Former::text('peso')->label('Peso')->class('form-control') }}
                                </div>
                                <div class="col-xs-8 col-sm-8 col-md-8 col-lg-8">
                                    {{ Former::text('altura')->label('Altura')->class('form-control') }}
                                </div>
                            </div>
                            {{ Former::text('lesao_anterior')
                                ->label('Já sofreu algum trauma ou lesão no passado fora a atual? Qual?')
                                ->class('form-control')
                            }}
                            {{ Former::text('reabilitacao_anterior')
                                ->label('Já fez reabilitação. (onde)')
                                ->class('form-control')
                            }}
                            {{ Former::text('numero_sessoes')
                                ->label('Número de sessões')
                                ->class('form-control')
                            }}
                            {{ Former::text('doencas_associadas')
                                ->label('Problemas de saúde pessoal / familiar')
                                ->class('form-control')
                            }}
                            {{ Former::text('medicamentos')
                                ->label('Uso de medicamentos')
                                ->class('form-control')
                            }}
                            {{ Former::text('alergia')
                                ->label('Tem alguma alergia?')
                                ->class('form-control')
                            }}
                            {{ Former::select('fumante')->options(Paciente::$SN)->label('Fumante')->class('form-control') }}
                            {{ Former::text('uso_drogas')->label('Uso de drogas. (Quais)')->class('form-control') }}
                            {{ Former::text('atividade_esportiva')->label('Possui alguma atividade esportiva de lazer (futebol, lutas, academia, etc)?')->class('form-control') }}
                            {{ Former::textarea('outros')->rows(8)->label('Outros')->class('form-control') }}
                        </div>
                    </div>
                </div>
                 <!-- Dados Complementares -->
                <div role="tabpanel" class="tab-pane" id="tab_complementos">
                    <div class="panel panel-default" style="border-top: none;">
                        <div class="panel-body" style="padding-top: 30px;">
                            {{ Former::text('tempo_empresa')
                                ->label('Tempo de empresa')
                                ->class('form-control')
                            }}
                            {{ Former::select('gosta_trabalhar_empresa')
                                ->options(Paciente::$SN)
                                ->label('Gosta de trabalhar na empresa')
                                ->class('form-control')
                            }}
                            {{ Former::textarea('aspectos_positivos_empresa')
                                ->rows(2)
                                ->label('Aspectos positivos da empresa')
                                ->class('form-control')
                            }}
                            {{ Former::textarea('aspectos_negativos_empresa')
                                ->rows(2)
                                ->label('Aspectos negativos da empresa')
                                ->class('form-control')
                            }}
                            {{ Former::text('num_empresas_trabalhou')
                                ->label('Nº de empresas que trabalhou')
                                ->class('form-control')
                            }}
                            {{ Former::text('trabalhos_extras')
                                ->label('Faz trabalhos extras? Que tipo?')
                                ->class('form-control')
                            }}
                            {{ Former::select('pegou_atestado')
                                ->options(Paciente::$SN)
                                ->label('Já pegou atestado')
                                ->class('form-control')
                            }}
                            <div class="row">
                                <div class="col-xs-16 col-md-8">
                                    {{ Former::select('acidente_trabalho')
                                        ->options(Paciente::$SN)
                                        ->label('Acidente de trabalho')
                                        ->class('form-control')
                                    }}
                                </div>
                                <div class="col-xs-16 col-md-8">
                                    {{ Former::text('tempo_afastamento')
                                        ->label('Tempo de afastamento')
                                        ->class('form-control')
                                    }}
                                </div>
                            </div>
                            {{ Former::text('acidente_transito')
                                ->label('Já sofreu acidente de trânsito (\'moto ou carro\')?')
                                ->class('form-control')
                            }}
                            {{ Former::select('utiliza_motocicleta')
                                ->options(Paciente::$SN)
                                ->label('Utiliza motocicleta como meio de transporte?')
                                ->class('form-control')
                            }}
                            {{ Former::textarea('afastamento_anterior')
                                ->rows(2)
                                ->label('Houve afastamento anterior e em que condições ocorreu')
                                ->class('form-control')
                            }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        {{ Former::textarea('observacoes')->rows(3)
            ->label('Observações <small style="font-weight: normal;">(Uso interno)</small>')
            ->class('form-control') }}

    {{ Former::close() }}

@else
    <h4 class="text-center">
        Formulário Anamnese não disponível para sua credencial de acesso
    </h4>
@endif
