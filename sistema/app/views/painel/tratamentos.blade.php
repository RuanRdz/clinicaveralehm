
<div class="row">
    <div class="col-xs-16 col-sm-16 col-md-5">
        <div class="panel panel-default">
            <div class="panel-heading">
                <div class="row">
                    <div class="col-xs-8 text-primary">
                        <strong>Tratamentos</strong>
                    </div>
                    <div class="col-xs-8 text-right">
                        <a
                            class="btn btn-default"
                            href="{{ route('tratamentosCreate', ['id' => $paciente->id]) }}"
                            title="Novo tratamento"
                            {{User::allowedCredentials([10, 30], true)?'':'disabled="disabled"'}}
                        >
                            <span class="text-primary"><i class="fa fa-plus fa-fw"></i> Novo Tratamento</span>
                        </a>
                    </div>
                </div>
            </div>
            @if (count($listagemTratamentos) > 0)
                <table class="table table-sm table-bordered table-striped table-hover valign-middle table-painel">
                    <tr>
                        <th style="width: 30px">ID</th>
                        <th style="width: 80px">Criado em</th>
                        <th>Profissional</th>
                        <th style="width: 90px" class="text-center">Situação</th>
                        <th style="width: 30px"></th>
                    </tr>
                    @foreach($listagemTratamentos as $row)
                        <?php
                        $textColor = 'color: #707070;';
                        $bgSituacao = '';
                        if ($tratamento) :
                            if ($row->id == $tratamento->id) :
                                $textColor = 'color: blue; background: #D4F0FF;';
                            endif;
                        endif;
                        if (!is_null($row->tratamentosituacao)) :
                            $bgSituacao = 'background: '.$row->tratamentosituacao->bg_color.' !important;';
                        endif;
                        ?>
                        <tr>
                            <td style="{{ $textColor }}">
                                #{{ $row->id }}
                            </td>
                            <td style="{{ $textColor }}">
                                {{ $row->created_at }}
                            </td>
                            <td style="{{ $textColor }}">
                                {{ $row->terapeuta->name }}
                            </td>
                            <td 
                                class="text-center"
                                style="{{ $textColor }} {{ $bgSituacao }}">
                                {{ !is_null($row->tratamentosituacao) ? $row->tratamentosituacao->nome : '' }}
                            </td>
                            <td class="text-center" style="{{ $textColor }}">
                                <a 
                                    class="cursor-pointer"
                                    style="font-size: 14px; {{ $textColor }}" 
                                    href="{{ route('painel', ['id' => $paciente->id, 'id2' => $row->id]) }}">
                                    <i class="fa fa-arrow-right fa-lg"></i>
                                </a>
                            </td>
                        </tr>
                    @endforeach
                </table>
            @endif
        </div>
    </div>
    @if($tratamento)
        <div class="col-xs-16 col-sm-16 col-md-6">
            <div class="px-3">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <div class="row">
                            <div class="col-xs-8 text-primary">
                                <strong>
                                    Tratamento 
                                    <span style="color: blue;">#{{$tratamento->id}}</span>
                                </strong>
                            </div>
                            <div class="col-xs-8 text-right">
                                <a
                                    href="{{ route('tratamentosEdit', ['id' => $tratamento->id]) }}"
                                    class="btn btn-primary"
                                    title="Editar tratamento"
                                    {{User::allowedCredentials([10, 30], true)?'':'disabled="disabled"'}}
                                >
                                    <i class="fa fa-pencil"></i> Editar Tratamento
                                </a>
                            </div>
                        </div>
                    </div>
                    <div class="panl-body">
                        <table class="table table-condensed table-bordered valign-middle table-painel">
                            <tr>
                                <td>Tipo de Tratamento</td>
                                <td>{{ !is_null($tratamento->tratamentotipo) ? $tratamento->tratamentotipo->nome : '' }}</td>
                            </tr>
                            <tr>
                                <td>Profissional</td>
                                <td>{{ !is_null($tratamento->terapeuta) ? $tratamento->terapeuta->fullNameCrefito : '' }}</td>
                            </tr>
                        </table>
                        <div class="px-2 pt-8 pb-6">
                            {{ nl2br($tratamento->observacoes) }}
                        </div>
                    </div>
                    <div class="panel-footer">
                        <div class="text-center my-2">
                            <a
                                class="btn btn-default"
                                href="{{ route('tratamentosShow', ['id' => $tratamento->id, 'layout' => 'p']) }}">
                                <i class="fa fa-user-o"></i> Guia Paciente
                            </a>
                            <a
                                class="btn btn-default"
                                href="{{ route('tratamentosShow', ['id' => $tratamento->id, 'layout' => 'e']) }}">
                                <i class="fa fa-institution"></i> Guia Empresa
                            </a>
                            <a
                                class="btn btn-default"
                                href="{{ route('tratamentosLaudo', ['id' => $tratamento->id]) }}">
                                <i class="fa fa-balance-scale"></i> Laudo
                            </a>
                        </div>
                        <div class="text-center my-2">
                            <a
                                href="#"
                                class="btn btn-default btn-visualizar-alteracoes-agenda">
                                <i class="fa fa-edit fa-fw"></i> Registro de alterações
                            </a>
                            <a
                                class="btn btn-default"
                                id="btn-notificacoes-listagem" href="{{ route('tratamentonotificacoes', ['id' => $tratamento->id]) }}">
                                <i class="fa fa-bell-o"></i> Notificações
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xs-16 col-sm-16 col-md-5">
            @include('painel.agenda')
        </div>
    @endif
</div>

