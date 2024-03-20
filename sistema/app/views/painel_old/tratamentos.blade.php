
<div class="panel panel-default">
	
	<div class="panel-heading" style="padding-top: 9px; padding-bottom: 9px;">
	
		<div class="row">
			<div class="col-xs-10 text-primary">
				<strong>Tratamentos</strong>
			</div>
			<div class="col-xs-6 text-right">
				<a
					class="btn btn-primary btn-xs"
					href="{{ route('tratamentosCreate', ['id' => $paciente->id]) }}"
					title="Novo tratamento"
				><i class="fa fa-plus fa-fw"></i></a>
			</div>
		</div>
	</div>
	
	<div class="panel-body">
		
		@if (count($listagemTratamentos) > 0)

			<table class="table table-sm table-bordered table-striped table-hover valign-middle table-painel">
				
				<tr>
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
								style="font-size: 14px; {{ $textColor }}" 
								href="{{ route('painel', ['id' => $paciente->id, 'id2' => $row->id]) }}">
								<i class="fa fa-thumb-tack fa-lg"></i>
							</a>
						</td>
					</tr>
				@endforeach
			</table>

		@endif

	</div>

	<div class="panel-footer">
		
		@if($tratamento)

			<table class="table table-sm table-bordered table-hover valign-middle table-painel">
				
				<tr>
					<td style="width:30%" class="text-danger">Área de Trabalho</td>
					<td>{{ !is_null($tratamento->workspace) ? $tratamento->workspace->nome : '' }}</td>
				</tr>
				<tr>
					<td class="text-danger">Profissional</td>
					<td>{{ !is_null($tratamento->terapeuta) ? $tratamento->terapeuta->fullNameCrefito : '' }}</td>
				</tr>
				<tr class="active">
					<td style="color: #000;">Lesão | Conduta</td>
					<td style="color: #000;">
						{{ !is_null($tratamento->lesao) ? $tratamento->lesao->nome : '' }}
						@if($tratamento->lesao_tratamento)
							| {{ Lesao::$opcoesTratamentoLesao[$tratamento->lesao_tratamento] }}
						@endif
					</td>
				</tr>
				<tr class="active">
					<td>Segmento | Membro</td>
					<td>
						{{ !is_null($tratamento->membro) ? $tratamento->membro->nome : '' }}
						@if($tratamento->membro_tipo)
							| {{ Membro::$tipoMembro[$tratamento->membro_tipo] }}
						@endif
					</td>
				</tr>
				<tr class="active">
					<td>Data da lesão</td>
					<td>{{ $tratamento->data_lesao }}</td>
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
					<td>Médico</td>
					<td>{{ !is_null($tratamento->medico) ? $tratamento->medico->nome : '' }}</td>
				</tr>
				<tr>
					<td>Convênio</td>
					<td>{{ !is_null($tratamento->convenio) ? $tratamento->convenio->nome : '' }}</td>
				</tr>
				<tr>
					<td>Tipo Tratamento</td>
					<td>{{ !is_null($tratamento->tratamentotipo) ? $tratamento->tratamentotipo->nome : '' }}</td>
				</tr>
				<tr style="display: none;">
					<td>Sessões</td>
					<td>{{ $tratamento->sessoes }}</td>
				</tr>
				@if($tratamento->observacoes)
					<tr class="text-justify">
						<td>Observações <small style="font-weight: normal;">(Uso interno)</small></td>
						<td>{{ nl2br($tratamento->observacoes) }}</td>
					</tr>
				@endif

			</table>


			<p class="text-center" style="margin-top: 10px; margin-bottom: 0;">
				
				<a
					href="{{ route('tratamentosEdit', ['id' => $tratamento->id]) }}"
					class="btn btn-default btn-xs"
					title="Editar tratamento">
					<i class="fa fa-pencil"></i> Editar
				</a>

				<a
					class="btn btn-default btn-xs"
					href="{{ route('tratamentosShow', ['id' => $tratamento->id, 'layout' => 'p']) }}">
					<i class="fa fa-user-o"></i> Guia Paciente
				</a>
				<a
					class="btn btn-default btn-xs"
					href="{{ route('tratamentosShow', ['id' => $tratamento->id, 'layout' => 'e']) }}">
					<i class="fa fa-institution"></i> Guia Empresa
				</a>
				<a
					class="btn btn-default btn-xs"
					href="{{ route('tratamentosLaudo', ['id' => $tratamento->id]) }}">
					<i class="fa fa-balance-scale"></i> Laudo
				</a>
				<a
					href="#"
					class="btn btn-default btn-xs btn-visualizar-alteracoes-agenda"
					title="Visualizar registro de alterações">
					<i class="fa fa-edit fa-fw"></i>
				</a>
				<a
					class="btn btn-default btn-xs"
					id="btn-notificacoes-listagem" href="{{ route('tratamentonotificacoes', ['id' => $tratamento->id]) }}">
					<i class="fa fa-bell-o"></i>
				</a>

				@if (User::allowedCredentials([10], true))
					<a
						href="#faturamento"
						class="btn btn-default btn-xs btn-visualizar-faturamento-paciente"
						title="Visualizar Faturamento Paciente">
						&nbsp;&nbsp;&nbsp;<i class="fa fa-dollar fa-fw"></i>&nbsp;&nbsp;&nbsp;
					</a>
				@endif

			</p>

			<p class="text-center" style="margin-top: 10px; margin-bottom: 0;">

				{{ View::make('layouts.admin.update-info')->with(array('user' => $tratamento))->render() }}

			</p>

		@else
		
			<h4 class="text-center">Nenhum tratamento realizado</h4>

		@endif

	</div>

</div>
