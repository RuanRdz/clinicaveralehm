<div style="font-family:Arial,'Sans-Serif'; font-size:12px; text-align:left;">

    <div style="text-align: center">
        {{ View::make('layouts.admin.print-header') }}
    </div>

    @if($display->cabecalho)
        <table style="width:100%; border-collapse: collapse; text-align:left;">
            <tr>
                <td style="width:50%; border:1px solid #ccc;">
                    <sup class="block-inline">Paciente</sup>
                    <div style="font-weight: bold;">{{ $t->paciente->nome }}</div>
                </td>
                <td style="width:50%; border:1px solid #ccc;">
                    <sup class="block-inline">RG</sup>
                    <div style="font-weight: bold;">
                        @if($display->rg)
                            {{ $t->paciente->rg }}
                        @endif
                    </div>
                </td>
            </tr>
            <tr>
                <td style="border:1px solid #ccc;">
                    <sup class="block-inline">Endereço</sup>
                    <div style="font-weight: bold;">
                        @if($display->endereco)
                            {{ $t->paciente->endereco }}
                        @endif
                    </div>
                </td>
                <td style="border:1px solid #ccc;">
                    <sup class="block-inline">CPF</sup>
                    <div style="font-weight: bold;">
                        @if($display->cpf)
                            {{ $t->paciente->cpf }}
                        @endif 
                    </div>
                </td>
            </tr>
            <tr>
                <td style="border:1px solid #ccc;">
                    <sup class="block-inline">Cidade</sup>
                    <div style="font-weight: bold;">
                        @if($display->cidade)
                            {{ $t->paciente->cidade->nome }} / {{ $t->paciente->cidade->estado_uf }}
                        @endif
                    </div>
                </td>
                <td style="border:1px solid #ccc;">
                    <sup class="block-inline">Data de nascimento</sup>
                    <div style="font-weight: bold;">
                        @if($display->datanascimento)
                            {{ $t->paciente->nascimento }}
                        @endif
                    </div>
                </td>
            </tr>
            <tr>
                <td style="border:1px solid #ccc;">
                    <sup class="block-inline">Telefones</sup>
                    <div style="font-weight: bold;">
                        @if($display->telefones)
                            @if (!empty($t->paciente->fone_residencial))
                                Res:
                                {{ $t->paciente->fone_residencial }}
                                &nbsp;&nbsp;
                            @endif
                            @if (!empty($t->paciente->fone_celular))
                                Cel:
                                {{ $t->paciente->fone_celular }}
                                @if (!empty($t->paciente->operadora_celular))
                                    ({{ $t->paciente->operadora_celular }})
                                @endif
                                &nbsp;&nbsp;
                            @endif
                            @if (!empty($t->paciente->fone_comercial))
                                Com:
                                {{ $t->paciente->fone_comercial }}
                                &nbsp;&nbsp;
                            @endif
                            @if (!empty($t->paciente->fone_recado))
                                Recado:
                                {{ $t->paciente->fone_recado }}
                            @endif
                        @endif
                    </div>
                </td>
                <td style="border:1px solid #ccc;">
                    <sup class="block-inline">Carteirinha</sup>
                    <div style="font-weight: bold;">
                        @if($display->carteirinha)
                            {{ $t->paciente->carteirinha }}
                        @endif
                    </div>
                </td>
            </tr>
        </table>
    @endif

    @if($display->tratamento)
        <div style="text-align: center">
            <h4>TRATAMENTO</h4>
        </div>
        <table style="width:100%; border-collapse: collapse; text-align:left;">
            <tr>
                <td style="width:50%; border:1px solid #ccc;">
                    <sup class="block-inline">Início do Tratamento</sup>
                    <div style="font-weight: bold;">
                        @if($display->iniciotratamento)
                            {{ $t->created_at }}
                        @endif
                    </div>
                </td>
                <td style="width:50%; border:1px solid #ccc;">
                    <sup class="block-inline">Data da Lesão</sup>
                    <div style="font-weight: bold;">
                        @if($display->datalesao)
                            {{ $t->data_lesao }}
                        @endif
                    </div>
                </td>
            </tr>
            <tr>
                <td style="border:1px solid #ccc;">
                    <sup class="block-inline">Tipo</sup>
                    <div style="font-weight: bold;">
                        @if($display->tipo)
                            {{ $t->tratamentotipo->nome }}
                        @endif
                    </div>
                </td>
                <td style="border:1px solid #ccc;">
                    <sup class="block-inline">Data da Cirurgia</sup>
                    <div style="font-weight: bold;">
                        @if($display->datacirurgia)
                            {{ $t->data_cirurgia }}
                        @endif
                    </div>
                </td>
            </tr>
            <tr>
                <td style="border:1px solid #ccc;">
                    <sup class="block-inline">Médico</sup>
                    <div style="font-weight: bold;">
                        @if($display->medico)
                            {{ $t->medico ? $t->medico->nome : null }}
                        @endif
                    </div>
                </td>
                <td style="border:1px solid #ccc;">
                    <sup class="block-inline">Lesão</sup>
                    <div style="font-weight: bold;">
                        @if($display->lesao)
                            {{ $t->lesao ? $t->lesao->nome : null}}
                        @endif
                    </div>
                </td>
            </tr>
            <tr>
                <td style="border:1px solid #ccc;">
                    <sup class="block-inline">Terapeuta Ocupacional / Fisioterapeuta</sup>
                    <div style="font-weight: bold;">
                        @if($display->profissional)
                            @if($t->terapeuta)
                                {{ $t->terapeuta->fullNameCrefito }}
                            @endif
                        @endif
                    </div>
                </td>
                <td style="border:1px solid #ccc;">
                    <sup class="block-inline">Membro</sup>
                    <div style="font-weight: bold;">
                        @if($display->membro)
                            {{ $t->membro ? $t->membro->nome : null }}
                        @endif
                    </div>
                </td>
            </tr>
            <tr>
                <td style="border:1px solid #ccc;">
                    <sup class="block-inline">Convênio</sup>
                    <div style="font-weight: bold;">
                        @if($display->convenio)
                            @if ($t->convenio)
                                {{ $t->convenio->nome }}
                                @if ($t->convenio->cidade_id)
                                    / {{ $t->convenio->cidade->nome }}
                                    - {{ $t->convenio->cidade->estado_uf }}
                                @endif
                            @endif
                        @endif
                    </div>
                </td>
                <td style="border:1px solid #ccc;">
                    <sup class="block-inline">Sessões</sup>
                    <div style="font-weight: bold;">
                        @if($display->numerosessoes)
                            {{ $t->sessoes }}
                        @endif
                    </div>
                </td>
            </tr>
        </table>
    @endif

    @if($display->agenda)
        <div style="text-align: center">
            <h4>AGENDA</h4>
        </div>
        <table style="width:100%; border-collapse: collapse; text-align:left;">
            <tr>
                @if($display->sessoes)
                    <th style="border:1px solid #ccc;">Sessão</th>
                @endif
                @if($display->datasessao)
                    <th style="border:1px solid #ccc;">Data sessão</th>
                @endif
                @if($display->horasessao)
                    <th style="border:1px solid #ccc;">Horário</th>
                @endif
                @if($display->situacao)
                    <th style="border:1px solid #ccc;">Situação</th>
                @endif
            </tr>
            @foreach ($t->agendas()->orderBy('sessao')->get() as $row)
                <tr>
                    @if($display->sessoes)
                        <td style="border:1px solid #ccc;">{{ $row->sessao }}</td>
                    @endif
                    @if($display->datasessao)
                        <td style="border:1px solid #ccc;">
                            @if($row->data_sessao)
                                {{ diaBr(date('D', strtotime($row->data_sessao))) }},
                                {{ $row->data_sessao }}
                            @endif
                        </td>
                    @endif
                    @if($display->horasessao)
                        <td style="border:1px solid #ccc;">{{ horarios()[$row->inicio] }}</td>
                    @endif
                    @if($display->situacao)
                        <td style="border:1px solid #ccc;">{{ $row->agendasituacao->nome_sumario }}</td>
                    @endif
                </tr>
            @endforeach
        </table>
    @endif

	<div style="text-align: center">
		{{ View::make('layouts.admin.print-footer') }}
	</div>
</div>