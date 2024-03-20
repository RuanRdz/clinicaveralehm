<div class="terminologia">
    <table>
        <tr>
            @if ($tuTree2)
                <td class="title col-title">{{ mb_strtoupper($tuTitles[0]['label'], 'UTF-8') }}</td>
            @endif

            @if ($tuTree41 || $tuTree42 || $tuTree43)
                <td class="title col-title">{{ mb_strtoupper($tuTitles[1]['label'], 'UTF-8') }}</td>
            @endif

            @if ($tuTree4)
                <td class="title col-title">{{ mb_strtoupper($tuTitles[2]['label'], 'UTF-8') }}</td>
            @endif
        </tr>
        <tr>
            @if ($tuTree2)
                <td class="col-content">{{ $tuTree2 }}</td>
            @endif

            @if ($tuTree41 || $tuTree42 || $tuTree43)
                <td class="col-content">
                    <table>
                        <tr>
                            @if ($tuTree41)
                                <td style="border-right: 1px solid #e0e0e0;">
                                    <div class="subtitle">Componente Sensório-motor</div>
                                    {{ $tuTree41 }}
                                </td>
                            @endif
                            @if ($tuTree42 || $tuTree43)
                                <td style="padding-left: 5px;">
                                    @if ($tuTree42)
                                        <div class="subtitle">Integração Cognitiva e Componentes Cognitivos</div>
                                        {{ $tuTree42 }}
                                    @endif
                                    @if ($tuTree43)
                                        <div class="subtitle">Habilidades Psicossociais e Componentes Psicológicos</div>
                                        {{ $tuTree43 }}
                                    @endif
                                </td>
                            @endif
                        </tr>
                    </table>
                </td>
            @endif

            @if ($tuTree4)
                <td class="col-content">{{ $tuTree4 }}</td>
            @endif
        </tr>
    </table>
</div>
