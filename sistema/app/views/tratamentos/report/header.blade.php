
<div class="report">
    <table>
        <tbody>
            <tr>
                <td style="width: 50%; padding: 3px;">
                    <sup class="block-inline">Paciente</sup>
                    <div class="-mt-1 font-bold">{{ $patient_name }}</div>
                </td>
                <td style="width: 50%; padding: 3px;">
                    <sup class="block-inline">Data da Lesão</sup>
                    <div class="-mt-1 js-hide-content">
                        {{ $treatment->data_lesao }}
                        <i style="cursor:pointer;" class="fa fa-eye-slash hidden-print text-danger js-btn-hide-content"></i>
                    </div>
                </td>
            </tr>
            <tr>
                <td style="padding: 3px;">
                    <sup class="block-inline">Tratamento</sup>
                    <div class="-mt-1 js-hide-content"">
                        {{ $treatment->tratamentotipo->nome }}
                        <i style="cursor:pointer;" class="fa fa-eye-slash hidden-print text-danger js-btn-hide-content"></i>
                    </div>
                </td>
                <td style="padding: 3px;">
                    <sup class="block-inline">Data da Cirurgia</sup>
                    <div class="-mt-1 js-hide-content">
                        {{ $treatment->data_cirurgia }}
                        <i style="cursor:pointer;" class="fa fa-eye-slash hidden-print text-danger js-btn-hide-content"></i>
                    </div>
                </td>
            </tr>
            <tr>
                <td style="padding: 3px;">
                    <sup class="block-inline">Médico</sup>
                    <div class="-mt-1 js-hide-content">
                        {{ $treatment->medico ? $treatment->medico->nome : null }}
                        <i style="cursor:pointer;" class="fa fa-eye-slash hidden-print text-danger js-btn-hide-content"></i>
                    </div>
                </td>
                <td style="padding: 3px;">
                    <sup class="block-inline">Lesão</sup>
                    <div class="-mt-1 js-hide-content">
                        {{ $treatment->lesao ? $treatment->lesao->nome : null}}
                        @if($treatment->lesao_tratamento)
                            - {{ Lesao::$opcoesTratamentoLesao[$treatment->lesao_tratamento] }}
                        @endif
                        <i style="cursor:pointer;" class="fa fa-eye-slash hidden-print text-danger js-btn-hide-content"></i>
                    </div>
                </td>
            </tr>
            <tr>
                <td style="padding: 3px;">
                    <sup class="block-inline">Terapeuta Ocupacional / Fisioterapeuta</sup>
                    <div class="-mt-1 js-hide-content">
                        @if($treatment->terapeuta)
                            {{ $treatment->terapeuta->fullNameCrefito }}
                        @endif
                        <i style="cursor:pointer;" class="fa fa-eye-slash hidden-print text-danger js-btn-hide-content"></i>
                    </div>
                </td>
                <td style="padding: 3px;">
                    <sup class="block-inline">Membro</sup>
                    <div class="-mt-1 js-hide-content">
                        {{ $treatment->membro ? $treatment->membro->nome : null }}
                        @if($treatment->membro_tipo)
                            - {{ Membro::$tipoMembro[$treatment->membro_tipo] }}
                        @endif
                        <i style="cursor:pointer;" class="fa fa-eye-slash hidden-print text-danger js-btn-hide-content"></i>
                    </div>
                </td>
            </tr>
            <tr>
                <td style="padding: 3px;" colspan="2">
                    @if($treatment->info_sessoes)
                        {{ $treatment->info_sessoes }}
                    @else
                        Compareceu a {{ $num_sessoes }} sessões de Terapia Ocupacional
                        no período de {{ $sessao_inicial }} a {{ $sessao_final }}
                    @endif
                </td>
            </tr>
        </tbody>
    </table>
</div>