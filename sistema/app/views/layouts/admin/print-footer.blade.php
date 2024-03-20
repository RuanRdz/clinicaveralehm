<?php $s = Sistema::parametros()?>

<div class="text-center only-print" style="font-size: 6.5pt; margin: 10px 0 0 0">
    {{ $s['razao_social'] }} - CREFITO {{ $s['crefito'] }} - {{ $s['endereco'] }} - {{ $s['cidade'] }}
    <br />
    {{ $s['telefone'] }} / E-mail: {{ $s['email'] }}
</div>
