
<table class="hdd-box-bloqueio {{ $info['css_class'] }}" title="Bloqueio">
	<tr>
		<td style="vertical-align: top;">{{ $info['descricao_bloqueio'] }}</td>
		<td rowspan="2" class="hdd-box-bloqueio-trash">
			<a
				title="Editar"
				class="btn-agenda-editar-bloqueio"
				style="display: block; margin-bottom: 3px;"
				href="{{ route('agendasEditBloqueio', array('id' => $info['id'])) }}">
				<i class="fa fa-pencil"></i>
			</a>
			<a
				title="Excluir"
				class="confirm-destroy"
				style="display: block;"
				href="{{ route('agendasDestroyBloqueio', array('id' => $info['id'])) }}">
				<i class="fa fa-times"></i>
			</a>
		</td>
	</tr>
	@if (!empty($info['fim']))
		<tr>
			<td>
				<small><b>Até {{ $info['fim'] }}</b></small>
			</td>
		</tr>
	@endif
	<tr>
		<td style="font-size: 9px; text-align: right;">
			<span title="Usuário">{{ $info['created_by'] }}</span> /
			<span title="Cadastrado por">{{ $info['autor'] }}</span>
		</td>
	</tr>
</table>