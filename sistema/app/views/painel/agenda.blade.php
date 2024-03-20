
<div class="panel panel-default">
	<div class="panel-heading">
		<div class="text-primary">
            <div class="row">
                <div class="col-xs-8 text-primary">
                    <strong>Agenda</strong>
                </div>
                <div class="col-xs-8 text-right">
                    @if(count($sessoes) > 0 && $tratamento->liberado_para_edicao)
                        <a 
                            href="{{ route('agendasEdicaoRapida', ['tratamento_id' => $tratamento->id]) }}" 
                            class="btn btn-primary btn-edicao-rapida-sessoes">
                            <i class="fa fa-pencil"></i> Editar todos
                        </a>
                    @endif
                </div>
            </div>
		</div>
	</div>
    <table class="table table-sm table-hover table-bordered table-condensed valign-middle table-painel text-center">
        <thead>
            <tr>
                <td style="width:70px;">Sessão</td>
                <td style="width:130px;"><i class="fa fa-calendar"></i> Data</td>
                <td style="width:80px;"><i class="fa fa-clock-o"></i> Horário</td>
                <td>Situação</td>
            </tr>
        </thead>
        <tbody class="js-sort-items-agenda">
            @foreach ($sessoes as $row)
            <tr
                data-item-id="{{ $row->id }}"
                class="grabbable">
                <td>
                    @if($row->allowEdit() && $tratamento->liberado_para_edicao)
                        <a
                            class="btn {{ $idUltimaSessao == $row->id ? 'btn-info' : 'btn-primary' }} btn-xs btn-agendar"
                            href="{{ route('agendasEdit', ['id' => $row->id]) }}"
                        >&nbsp;&nbsp;<strong>{{ $row->sessao }}</strong>&nbsp;&nbsp;</a>
                    @else
                        <span
                            class="btn btn-xs btn-default disabled"
                            title="Acesso Administrador Master requerido"
                        >&nbsp;&nbsp;<strong>{{ $row->sessao }}</strong>&nbsp;&nbsp;</span>
                    @endif
                </td>
                <td>
                    @if($row->data_sessao)
                    {{ diaBr(date('D', strtotime($row->data_sessao))) }},
                    {{ $row->data_sessao }}
                    @endif
                </td>
                <td
                    title="{{ !empty(horarios()[$row->fim]) ? 'Encerramento: '.horarios()[$row->fim] : '' }}">
                    {{ horarios()[$row->inicio] }}
                </td>
                <td style="background: {{ !is_null($row->agendasituacao) ? $row->agendasituacao->bg_color : '' }}">
                    {{ !is_null($row->agendasituacao) ? $row->agendasituacao->nome_sumario : '' }}
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
    @if($allowAddSessao && User::allowedCredentials([10, 30], true))
        <hr>
        <div class="pb-4">
            <form action="{{route('agendasStore')}}" method="POST" class="form-horizontal">
                {{ Form::token() }}
                <input type="hidden" name="tratamento_id" value="{{$tratamento->id}}">
                <div class="form-group">
                    <label class="col-sm-3 control-label">Adicionar</label>
                    <div class="col-sm-3">
                        <input type="text" name="num_sessoes" value="{{ $numSessoesDisponiveis }}" class="form-control" required>
                    </div>
                    <label class="col-sm-3 control-label" style="text-align: left;">Sessões</label>
                    <div class="col-sm-7">
                        <button type="submit" class="btn btn-primary">Salvar</button>
                    </div>
                </div>
            </form>
            <div class="pl-3">
                Quantidade disponível: <strong>{{ $numSessoesDisponiveis }}</strong>
            </div>
        </div>
    @else 
        <div class="py-4 text-center">
            <i class="fa fa-check-circle"></i> Todas as sessões foram geradas
        </div>
    @endif 
</div>