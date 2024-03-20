<div class="report">
    <table>
        
        <thead class="title">
            <tr>
                <th colspan="3">
                    @include('protocols.tests.header-report', array('test' => $tu['test']))
                </th>
            </tr>
        </thead>

        <thead class="column-title">
            <tr>
                @if ($tu['2'])
                    <th>{{ mb_strtoupper($tu['titles'][0]['label'], 'UTF-8') }}</th>
                @endif

                @if ($tu['41'] || $tu['42'] || $tu['43'])
                    <th>{{ mb_strtoupper($tu['titles'][1]['label'], 'UTF-8') }}</th>
                @endif

                @if ($tu['4'])
                    <th>{{ mb_strtoupper($tu['titles'][2]['label'], 'UTF-8') }}</th>
                @endif
            </tr>
        </thead>

        <tbody>
            <tr>
                @if ($tu['2'])
                    <td class="va-top">{{ $tu['2'] }}</td>
                @endif

                @if ($tu['41'] || $tu['42'] || $tu['43'])
                    <td class="va-top" style="padding: 0;">
                        <table>
                            <tr>
                                @if ($tu['41'])
                                    <td style="border: none;">
                                        <div class="subtitle" style="margin-bottom: 10px;">
                                            Componente Sensório-motor
                                        </div>
                                        {{ $tu['41'] }}
                                    </td>
                                @endif
                                @if ($tu['42'] || $tu['43'])
                                    <td class="va-top" style="border: none;">
                                        @if ($tu['42'])
                                            <div class="subtitle" style="margin-bottom: 10px;">
                                                Integração Cognitiva e Componentes Cognitivos
                                            </div>
                                            {{ $tu['42'] }}
                                        @endif
                                        @if ($tu['43'])
                                            <div class="subtitle" style="margin-top: 20px; margin-bottom: 10px;">
                                                Habilidades Psicossociais e Componentes Psicológicos
                                            </div>
                                            {{ $tu['43'] }}
                                        @endif
                                    </td>
                                @endif
                            </tr>
                        </table>
                    </td>
                @endif

                @if ($tu['4'])
                    <td class="va-top">{{ $tu['4'] }}</td>
                @endif
            </tr>
        </tbody>
    </table>
</div>
