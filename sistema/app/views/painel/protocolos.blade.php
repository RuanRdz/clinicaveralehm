
<div class="container">
    <div class="row">
        <div class="col-md-4 col-md-offset-4 py-3">
            <a 
                class="btn btn-block btn-info"
                href="{{ route('atividadesEdit', ['id' => $tratamento->id]) }}"
                target="_blank">
                <i class="fa fa-pencil fa-fw"></i>&nbsp;Descrever Relatório
            </a>
        </div>
        <div class="col-md-4 py-3">
            <a 
                href="{{route('report', ['treatment_id' => $tratamento->id])}}"
                class="btn btn-danger btn-block"
                target="_blank">
                <i class="fa fa-file-text-o fa-fw"></i>&nbsp;Relatório para impressão
            </a>
        </div>
    </div>
    @if ($tratamento && User::allowedCredentials([10, 20], true))
        @if ($tratamento->tratamentosituacao_id == 1)
            <div class="row">
                <div class="col-xs-16">
                    <div class="bg-white shadow-md">
                        <table class="table table-hover">
                            @foreach($menuProtocols as $specialty)
                                <?php 
                                /*
                                <thead>
                                    <tr>
                                        <th colspan="2" class="text-xl text-primary">
                                            {{ $specialty['name'] }}
                                        </th>
                                        <th class="text-gray-300" style="130px">
                                            Última avaliação
                                        </th>
                                    </tr>
                                </thead>
                                */
                                ?>
                                @foreach($specialty['protocols'] as $protocol)
                                    <tr>
                                        <th 
                                            colspan="4" 
                                            class="bg-green-100 text-xl text-primary font-bold"
                                        >
                                            {{ $protocol['name'] }}
                                        </th>
                                    </tr>
                                    @foreach($protocol['tests'] as $test)
                                        <tr>
                                            <td class="text-lg">
                                                @if ($test['route'])
                                                    <a
                                                        href="{{ route($test['route'], ['treatment_id' => $tratamento->id]) }}"
                                                        class="text-gray-900 block"
                                                        target="_blank">
                                                        {{ $test['name'] }}
                                                    </a>
                                                @else
                                                    <span class="text-gray-500">
                                                        {{ $test['name'] }}
                                                    </span>
                                                @endif
                                            </td>
                                            <td>
                                                {{ $test['description'] }}
                                            </td>
                                            <td>
                                                @if(isset($datasUltimasAvaliacoes[$test['namespace']]))
                                                    {{ timestampToBr($datasUltimasAvaliacoes[$test['namespace']]) }}
                                                @endif
                                            </td>
                                        </tr>
                                    @endforeach
                                @endforeach
                            @endforeach
                        </table>
                    </div>
                </div>
            </div>
        @else 
            <div class="text-center text-lg mt-6">
                Tratamento <strong>{{ $tratamento->tratamentosituacao->nome }}</strong>
            </div>
        @endif
    @endif
</div>
