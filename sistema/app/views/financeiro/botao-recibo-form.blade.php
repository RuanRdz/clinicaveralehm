@if($financeiro->pagamento)
    <a 
        class="btn btn-default"
        href="{{ route('financeiroGerarRecibo', ['id' => $financeiro->id]) }}" 
        target="_blank"
    >
        <span class="text-primary"><i class="fa fa-file-text-o fa-fw"></i> Recibo</span>
    </a>
@else 
    <span 
        class="btn btn-default"
        title="Para gerar o recibo, o lançamento deve estar pago."
    >
        <span class="text-gray-400"><i class="fa fa-file-text-o fa-fw"></i> Recibo</span>
    </span>
@endif
