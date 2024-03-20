@if ($tratamento)

	<h3 style="background: #f9f9f9;">Informações</h3>
	<table class="table table-hover table-bordered table-condensed" style="background:#f9f9f9;">
		<tr>
			<td colspan="2">
				<span style="color: blue; font-weight: bold;">{{ $tratamento->created_at }}</span>
				<span class="pull-right">#{{ $tratamento->id }}</span>
			</td>
		</tr>

		<tr>
			<td colspan="2">
				{{ View::make('layouts.admin.update-info')->with(array('user' => $tratamento))->render() }}
			</td>
		</tr>

		@if (User::allowedCredentials([10, 20], true))
			<tr>
				<td colspan="2" style="background:#fff; padding-top:10px; padding-bottom:10px; text-align:center;">

					<a
						href="{{ route('tratamentosEdit', ['id' => $tratamento->id]) }}"
						class="btn btn-default"
						title="Editar tratamento">
						<i class="fa fa-pencil"></i> Editar
					</a>
					&nbsp;&nbsp;&nbsp;

					<a
						class="btn btn-default"
						href="{{ route('prontuarioIndex', ['paciente_id' => $paciente->id]) }}">
						<i class="fa fa-book fa-lg"></i> Prontuário
					</a>

					&nbsp;&nbsp;&nbsp;

					@include('relatorio.menu', ['tratamento' => $tratamento])

					&nbsp;&nbsp;&nbsp;

					<a
						href="#"
						class="btn btn-default btn-menu-protocolos-tratamento">
						Protocolos
					</a>

					<br />
					<br />

					<a
						class="btn btn-default btn-xs"
						href="{{ route('tratamentosShow', ['id' => $tratamento->id, 'layout' => 'p']) }}">
						Guia Paciente
					</a>
					<a
						class="btn btn-default btn-xs"
						href="{{ route('tratamentosShow', ['id' => $tratamento->id, 'layout' => 'e']) }}">
						Guia Empresa
					</a>
					<a
						class="btn btn-default btn-xs"
						href="{{ route('pacientesArquivo', ['id' => $paciente->id]) }}">
						Arquivo
					</a>
					<a
						class="btn btn-default btn-xs"
						href="{{ route('tratamentosLaudo', ['id' => $tratamento->id]) }}">
						Laudo
					</a>
					<a
						class="btn btn-default btn-xs"
						id="btn-notificacoes-listagem" href="{{ route('tratamentonotificacoes', ['id' => $tratamento->id]) }}">
						<i class="fa fa-bell-o"></i>
					</a>
					<a
						href="#"
						class="btn btn-default btn-xs btn-visualizar-alteracoes-agenda"
						title="Visualizar registro de alterações">
						<i class="fa fa-edit fa-fw"></i>
					</a>

					@if (User::allowedCredentials([10], true))
						<a
							href="#"
							class="btn btn-default btn-xs btn-visualizar-faturamento-paciente"
							title="Visualizar Faturamento Paciente">
							<i class="fa fa-dollar fa-fw"></i>
						</a>
					@endif
				</td>
			</tr>
		@endif
		<tr>
			<td colspan="2" style="padding-top:8px; padding-bottom:8px;">
				<strong>{{ $paciente->nome }}</strong>
				&nbsp;&nbsp;
				<a target="blank" title="Ir para o cadastro paciente" href="{{ route('pacientesShow', ['id' => $paciente->id]) }}">
					<i class="fa fa-file-text"></i>
				</a>
			</td>
		</tr>

		<tr>
			<td style="width:30%" class="text-danger">Área de Trabalho</td>
			<td>{{ !is_null($tratamento->workspace) ? $tratamento->workspace->nome : '' }}</td>
		</tr>
		<tr>
			<td class="text-danger">Profissional</td>
			<td>{{ !is_null($tratamento->terapeuta) ? $tratamento->terapeuta->fullNameCrefito : '' }}</td>
		</tr>
		<tr>
			<td>Tipo</td>
			<td>{{ !is_null($tratamento->tratamentotipo) ? $tratamento->tratamentotipo->nome : '' }}</td>
		</tr>
		<tr>
			<td>Data da lesão</td>
			<td>{{ $tratamento->data_lesao }}</td>
		</tr>
		<tr>
			<td>Data da cirurgia</td>
			<td>{{ $tratamento->data_cirurgia }}</td>
		</tr>
		<tr>
			<td>Lesão</td>
			<td>
				{{ !is_null($tratamento->lesao) ? $tratamento->lesao->nome : '' }}
				@if($tratamento->lesao_tratamento)
					- {{ Lesao::$opcoesTratamentoLesao[$tratamento->lesao_tratamento] }}
				@endif
			</td>
		</tr>
		<tr>
			<td>Membro</td>
			<td>
				{{ !is_null($tratamento->membro) ? $tratamento->membro->nome : '' }}
				@if($tratamento->membro_tipo)
					- {{ Membro::$tipoMembro[$tratamento->membro_tipo] }}
				@endif
			</td>
		</tr>
		<tr>
			<td>Médico</td>
			<td>{{ !is_null($tratamento->medico) ? $tratamento->medico->nome : '' }}</td>
		</tr>
		<tr>
			<td>Convênio</td>
			<td>{{ !is_null($tratamento->convenio) ? $tratamento->convenio->nome : '' }}</td>
		</tr>
		<tr>
			<td>Sessões</td>
			<td>{{ $tratamento->sessoes }}</td>
		</tr>
		<tr class="text-justify">
			<td>Observações <small style="font-weight: normal;">(Uso interno)</small></td>
			<td>{{ nl2br($tratamento->observacoes) }}</td>
		</tr>

	</table>

@endif
