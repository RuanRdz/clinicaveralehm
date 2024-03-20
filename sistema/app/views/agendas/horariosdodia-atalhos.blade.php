
<?php $tratamento = $info['dados_tratamento'];?>

<div 
	class="hdd-atalhos" 
	data-atalhos-id="{{$info['id']}}"
	style="display: none;">
	
	@if($info['limite_de_faltas'])
		<div class="alert alert-danger" role="alert">
			<i class="fa fa-exclamation-triangle fa-lg"></i> 
			<strong>Verificar Faltas</strong>
		</div>
	@endif
	
	@if($info['avaliacoes_pendentes'])
		<div class="alert alert-danger" role="alert">
			<i class="fa fa-exclamation-triangle fa-lg"></i> 
			<strong>Avaliação não realizada para esta patologia</strong>
		</div>
	@endif

	<table 
		class="table table-bordered" 
		style="width: 490px!important; margin: 0; padding: 0; font-size: 12px;">
		<tr>
			<td 
				rowspan="15" 
				style="width: 130px; padding-right: 10px;">
				<a
					href="{{ route('painel', ['id' => $info['paciente_id'], 'id2' => $info['tratamento_id']]) }}"
					class="btn btn-info btn-block"
					style="text-align: left !important;">
					<i class="fa fa-stethoscope fa-lg fa-fw"></i> <strong>PAINEL</strong>
				</a>
                <a 
                    href="{{ route('painel', ['id' => $info['paciente_id'], 'id2' => $info['tratamento_id']]).'#tab-prontuario' }}"
                    class="btn btn-primary btn-block"
                    style="text-align: left !important;">
                    <i class="fa fa-file-text-o fa-lg fa-fw"></i> <strong>PRONTUÁRIO</strong>
                </a>
                <a 
                    href="{{ route('painel', ['id' => $info['paciente_id'], 'id2' => $info['tratamento_id']]).'#tab-financeiro' }}"
                    class="btn btn-danger btn-block"
                    style="text-align: left !important;">
                    <i class="fa fa-hashtag fa-lg fa-fw"></i> <strong>FINANCEIRO</strong>
                </a>
				<a
					href="{{ route('pacientesEdit', array('id' => $info['paciente_id'])) }}"
					class="btn btn-warning btn-block"
					style="text-align: left !important;">
					<i class="fa fa-user-circle fa-lg fa-fw"></i> <strong>CADASTRO</strong>
				</a>
			</td>
		</tr>

		<tr>
			<th colspan="2">
                <div class="text-lg truncate">{{ $info['nome'] }}</div>
                <div>Profissão: {{ $info['profissao'] }}</div>
                <div>Empresa: {{ $info['empresa'] }}</div>
                <div>Idade: {{ $info['idade'] }}</div>
            </th>
        </tr>
        
		<tr>
			<td style="width: 90px;" class="text-danger">F. Celular</td>
			<td style="font-weight: bold;">
				@if (!empty($info['fone_celular']))
					{{ $info['fone_celular'] }}
					@if (!empty($info['operadora_celular']))
						({{ $info['operadora_celular'] }})
					@endif
				@endif
			</td>
		</tr>
		<tr>
			<td class="text-danger">F. Residencial</td>
			<td>
				@if (!empty($info['fone_residencial']))
					{{ $info['fone_residencial'] }}
				@endif
			</td>
		</tr>
		<tr>
			<td class="text-danger">F. Empresa</td>
			<td>
				@if (!empty($info['fone_comercial']))
					{{ $info['fone_comercial'] }}
				@endif
			</td>
		</tr>
		<tr>
			<td class="text-danger">F. Recado</td>
			<td>
				@if (!empty($info['fone_recado']))
					{{ $info['fone_recado'] }}
				@endif
			</td>
		</tr>
		<tr>
			<td class="text-danger">E-mail</td>
			<td>
				@if (!empty($info['email']))
					{{ $info['email'] }}
				@else 
					<i class="fa fa-exclamation-triangle fa-lg"></i>
				@endif
			</td>
		</tr>

		<tr>
			<td colspan="2" style="border-bottom: 1px solid #303030; margin: 0; padding: 0;"></td>
		</tr>

		<tr>
			<td class="text-danger"><strong>Lesão</strong></td>
			<td style="font-size: 10px;">
				<strong>
				{{ !is_null($tratamento->lesao) ? $tratamento->lesao->nome : '' }}
				@if($tratamento->lesao_tratamento)
					- {{ Lesao::$opcoesTratamentoLesao[$tratamento->lesao_tratamento] }}
				@endif
				</strong>
			</td>
		</tr>
		<tr>
			<td class="text-danger">Membro</td>
			<td style="font-size: 10px;">
				{{ !is_null($tratamento->membro) ? $tratamento->membro->nome : '' }}
				@if($tratamento->membro_tipo)
					- {{ Membro::$tipoMembro[$tratamento->membro_tipo] }}
				@endif
			</td>
		</tr>
		<tr>
			<td class="text-danger">Data lesão</td>
			<td style="font-size: 10px;">{{ $tratamento->data_lesao }}</td>
		</tr>
		@if($tratamento->lesao_tratamento)
			@if(Lesao::$opcoesTratamentoLesao[$tratamento->lesao_tratamento] == 'pos_operatorio')
				<tr>
					<td class="text-danger">Data cirurgia</td>
					<td style="font-size: 10px;">{{ $tratamento->data_cirurgia }}</td>
				</tr>
			@endif
		@endif
		<tr>
			<td class="text-danger">Médico</td>
			<td style="font-size: 10px;">{{ !is_null($tratamento->medico) ? $tratamento->medico->nome : '' }}</td>
		</tr>
		<tr>
			<td class="text-danger">Convênio</td>
			<td style="font-size: 10px;">{{ !is_null($tratamento->convenio) ? $tratamento->convenio->nome : '' }}</td>
		</tr>
		<tr>
			<td class="text-danger" >
				Tratamento
			</td>
			<td style="font-size: 10px;">
				{{ !is_null($tratamento->tratamentotipo) ? $tratamento->tratamentotipo->nome : '' }}
			</td>
		</tr>
	</table>

</div>
