<p>Paciente: <strong>{{ $t->paciente->nome }}</strong></p>

<table class="table">
    <tr>
        <th style="width:25%">Início do Tratamento</th>
        <td style="width:25%">{{ $t->created_at }}</td>
        <th style="width:20%">
            Data da Lesão
            <i style="cursor:pointer;" class="fa fa-eye-slash hidden-print text-danger btn_hide_data_lesao"></i>
        </th>
        <td><span class="hide_data_lesao">{{ $t->data_lesao }}</span></td>
    </tr>
    <tr>
        <th>Tipo</th>
        <td>{{ $t->tratamentotipo->nome }}</td>
        <th>
            Data da Cirurgia
            <i style="cursor:pointer;" class="fa fa-eye-slash hidden-print text-danger btn_hide_data_cirurgia"></i>
        </th>
        <td><span class="hide_data_cirurgia">{{ $t->data_cirurgia }}</span></td>
    </tr>
    <tr>
        <th>Médico</th>
        <td>{{ $t->medico ? $t->medico->nome : null }}</td>
        <th>
            Lesão
            <i style="cursor:pointer;" class="fa fa-eye-slash hidden-print text-danger btn_hide_lesao"></i>
        </th>
        <td>
            <span class="hide_lesao">
                {{ $t->lesao ? $t->lesao->nome : null}}
                @if($t->lesao_tratamento)
                    - {{ Lesao::$opcoesTratamentoLesao[$t->lesao_tratamento] }}
                @endif
            </span>
        </td>
    </tr>
    <tr>
        <th>Terapeuta Ocupacional / Fisioterapeuta</th>
        <td>
            @if($t->terapeuta)
                {{ $t->terapeuta->fullNameCrefito }}
            @endif
        </td>
        <th>
            Membro
            <i style="cursor:pointer;" class="fa fa-eye-slash hidden-print text-danger btn_hide_membro"></i>
        </th>
        <td>
            <span class="hide_membro">
                {{ $t->membro ? $t->membro->nome : null }}
                @if($t->membro_tipo)
                    - {{ Membro::$tipoMembro[$t->membro_tipo] }}
                @endif
            </span>
        </td>
    </tr>
    <tr>
        <td colspan="4">
            @if($t->info_sessoes)
                {{ $t->info_sessoes }}
            @else
                Compareceu a {{ $num_sessoes }} sessões de Terapia Ocupacional
                no período de {{ $sessao_inicial }} a {{ $sessao_final }}
            @endif
        </td>
    </tr>
</table>
