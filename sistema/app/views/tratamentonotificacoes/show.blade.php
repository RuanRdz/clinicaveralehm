<div class="alert {{ $notificacao->lido == 'Y' ? 'alert-success' : 'alert-warning' }}" role="alert">
	<a class="btn-notificacoes-excluir pull-right" href="{{ route('tratamentonotificacoesDestroy', ['id' => $notificacao->id]) }}">
		<i class="fa fa-trash"></i>
	</a>
	<div class="notificacoes-mensagem" style="cursor:pointer;" data-route="{{ route('tratamentonotificacoesAlterarEstado', ['id' => $notificacao->id]) }}">
		{{ $notificacao->mensagem }}
	</div>
</div>