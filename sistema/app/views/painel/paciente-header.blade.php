
    <div class="row">
        <div class="col-xs-4 col-sm-3 col-md-2 col-lg-2">
            <div class="p-2 w-full min-w-sm">
                <div 
                    class="circular-crop" 
                    style="background-image: url({{ $paciente->foto }});"></div>
            </div>
            <div class="my-3 text-center">
                <a
                    href="{{ route('pacientesEdit', ['id' => $paciente->id]) }}"
                    class="btn btn-primary mb-1">
                    <i class="fa fa-pencil"></i> Cadastro
                </a>
                <a
                    href="{{ route('pacientesArquivo', ['id' => $paciente->id]) }}"
                    class="btn btn-default mb-1">
                    <i class="fa fa-folder-open-o"></i> Arquivo
                </a>
            </div>
        </div>
        <div class="col-xs-12 col-sm-13 col-md-14">
            <div class="mb-3">
                <span class="text-xl text-black font-bold mr-4">{{ $paciente->nome }}</span>
                <span class="text-lg text-orange-500 mr-4 sm:block md:block">{{$paciente->profissao}}</span>
                <span class="text-lg text-gray-500 sm:block md:block">{{$paciente->idade}} anos</span>
            </div>
            <div class="row">
                <div class="col-xs-16 col-sm-16 col-md-6 col-lg-6">
                    <div class="panel panel-default">
                        <table class="table table-condensed table-bordered valign-middle table-painel">
                            <tr>
                                <td>Empresa</td>
                                <td class="text-black">{{$paciente->empresa}}</td>
                            </tr>
                            @if($tratamento)
                                <tr>
                                    <td>Tratamento</td>
                                    <td style="color: blue;">#{{$tratamento->id}}</td>
                                </tr>
                                <tr>
                                    <td>Lesão / Conduta</td>
                                    <td>
                                        <span class="text-black">
                                            {{ !is_null($tratamento->lesao) ? $tratamento->lesao->nome : '' }}
                                        </span>
                                        @if($tratamento->lesao_tratamento)
                                            <div><small>{{ Lesao::$opcoesTratamentoLesao[$tratamento->lesao_tratamento] }}</small></div>
                                        @endif
                                    </td>
                                </tr>
                                <tr>
                                    <td>Data da lesão</td>
                                    <td>{{ $tratamento->data_lesao }}</td>
                                </tr>
                                <tr>
                                    <td>Segmento / Dominância</td>
                                    <td>
                                        {{ !is_null($tratamento->membro) ? $tratamento->membro->nome : '' }}
                                        @if($tratamento->membro_tipo)
                                            <div><small>{{ Membro::$tipoMembro[$tratamento->membro_tipo] }}</small></div>
                                        @endif
                                    </td>
                                </tr>
                                @if($tratamento->lesao_tratamento)
                                    @if($tratamento->lesao_tratamento == 'pos_operatorio')
                                        <tr>
                                            <td>Data da cirurgia</td>
                                            <td>{{ $tratamento->data_cirurgia }}</td>
                                        </tr>
                                        <tr>
                                            <td>Técnica cirúrgica</td>
                                            <td>{{ $tratamento->tecnica_cirurgica }}</td>
                                        </tr>
                                    @endif
                                @endif
                                <tr>
                                    <td>Convênio</td>
                                    <td>{{ !is_null($tratamento->convenio) ? $tratamento->convenio->nome : '' }}</td>
                                </tr>
                                <tr>
                                    <td>Médico</td>
                                    <td>{{ !is_null($tratamento->medico) ? $tratamento->medico->nome : '' }}</td>
                                </tr>
                            @endif
                        </table>
                    </div>
                </div>
                <div class="col-xs-16 col-sm-8 col-md-5 col-lg-5">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            Contato
                        </div>
                        <div class="m-0 p-0">
                            <table class="table table-condensed valign-middle table-painel">
                                <tr>
                                    <td style="width: 130px;">F. Celular:</td>
                                    <td>
                                        @if (!empty($paciente->fone_celular))
                                            {{ $paciente->fone_celular }}
                                            @if (!empty($paciente->operadora_celular))
                                                ({{ $paciente->operadora_celular }})
                                            @endif
                                        @endif
                                    </td>
                                </tr>
                                <tr>
                                    <td>F. Residencial:</td>
                                    <td>
                                        @if (!empty($paciente->fone_residencial))
                                            {{ $paciente->fone_residencial }}
                                        @endif
                                    </td>
                                </tr>
                                <tr>
                                    <td>F. Trabalho:</td>
                                    <td>
                                        @if (!empty($paciente->fone_comercial))
                                            {{ $paciente->fone_comercial }}
                                        @endif
                                    </td>
                                </tr>
                                <tr>
                                    <td>F. Recado:</td>
                                    <td>
                                        @if (!empty($paciente->fone_recado))
                                            {{ $paciente->fone_recado }}
                                        @endif
                                    </td>
                                </tr>
                                <tr>
                                    <td>E-mail:</td>
                                    <td>{{ $paciente->email }}</td>
                                </tr>
                                <tr>
                                    <td>Carteirinha:</td>
                                    <td>
                                        <strong class="mr-3">{{ $paciente->carteirinha }}</strong>
                                        @if($paciente->validadecarteirinha)
                                            Val.: {{$paciente->validadecarteirinha}} 
                                        @endif
                                    </td>
                                </tr>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="col-xs-16 col-sm-8 col-md-5 col-lg-5">
                    @include('painel.complexidade')
                </div>
            </div>
        </div>
    </div>
