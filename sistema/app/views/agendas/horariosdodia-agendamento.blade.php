
<table class="hdd-box hdd-box-agendamento {{ $info['css_class'] }}" title="Agendamento">
	<tr>
		<td style="vertical-align: top;">
			<div class="hdd-paciente">
				<h1>{{ mb_strtoupper($info['nome_agendamento'], 'UTF-8') }}</h1>

				<div class="btn-group pull-left" title="Informações agendamento">
					<button
						type="button"
						class="btn btn-default dropdown-toggle"
						data-toggle="dropdown"
						style="color: #202020; background: #A9A8D9 !important;">
						<i class="fa fa-file-text-o"></i>
					</button>
					<ul class="dropdown-menu" role="menu">
						<li>
							<table class="table table-bordered" style="width: 400px!important; margin: 0;">
								<tr>
									<td>Nome</td>
									<td>{{ mb_strtoupper($info['nome_agendamento'], 'UTF-8') }}</td>
								</tr>
								<tr>
									<td style="width: 80px;">Telefones</td>
									<td>{{ $info['telefone_agendamento'] }}</td>
								</tr>
								<tr>
									<td>Doença</td>
									<td>{{ $info['doenca_agendamento'] }}</td>
								</tr>
								<tr>
									<td>Médico</td>
									<td>{{ $info['medico_agendamento'] }}</td>
								</tr>
								<tr>
									<td>Convênio</td>
									<td>{{ $info['convenio_agendamento'] }}</td>
								</tr>
								<tr>
									<td>Observação</td>
									<td>{{ $info['observacao_agendamento'] }}</td>
								</tr>
							</table>
						</li>
					</ul>
				</div>
			</div>
		</td>
		<td rowspan="2" class="hdd-box-agendamento-trash">
			<a
				title="Editar"
				class="btn-agenda-editar-agendamento"
				style="display: block; margin-bottom: 3px;"
				href="{{ route('agendasEditAgendamento', array('id' => $info['id'])) }}">
				<i class="fa fa-pencil"></i>
			</a>
			<a 
				title="Excluir" 
				class="confirm-destroy" 
				style="display: block;"
				href="{{ route('agendasDestroyAgendamento', array('id' => $info['id'])) }}">
				<i class="fa fa-times"></i>
			</a>
		</td>
	</tr>
	<tr>
		<td style="font-size: 9px; text-align: right;">
			<span title="Usuário">{{ $info['created_by'] }}</span> /
			<span title="Cadastrado por">{{ $info['autor'] }}</span>
		</td>
	</tr>
</table>