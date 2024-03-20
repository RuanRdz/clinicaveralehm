<h4>Notificações</h4>

<h5>
	{{ $tratamento->paciente->nome }}
	<span class="pull-right">
		Tratamento <strong>{{ timestampToBr($tratamento->created_at) }}</strong>
	</span>
</h5>

<hr />

{{
Form::open(array(
		'route' => 'tratamentonotificacoesStore',
		'class' => 'form',
		'id' => 'form-tratamentonotificacoes',
		'role' => 'form'
	)
)
}}
{{ Form::hidden('tratamento_id', $tratamento->id) }}
	
	<div class="form-group">	
	    {{
		Form::textarea('mensagem', null,
			[
				'class' => 'form-control',
				'placeholder' => 'Nova Mensagem',
				'rows' => '3'
			]
		)
	    }}
	</div>

	<div class="form-group text-right">	
		{{
		Form::button(
			'Salvar',
			['type' => 'submit', 'class' => 'btn btn-primary']
		)
		}}
	</div>

{{ Form::close() }}

<hr />

<div class="tratamentonotificacoes-listagem">
	@foreach ($notificacoes as $row)
		<?php $notificacao = $row;?>
		{{ View::make('tratamentonotificacoes.show', compact('notificacao')) }}
	@endforeach
</div>
