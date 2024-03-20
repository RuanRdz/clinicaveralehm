<?php
$menuFinanceiro = [
    'financeiro',
    'movimentacao', 
    'pacientes', 
    'fluxo-de-caixa',
];
?>
<li class="dropdown {{ in_array(Request::segment(1), $menuFinanceiro) ? 'active' : '' }}">
    <a href="#" class="dropdown-toggle" data-toggle="dropdown">
        <i class="fa fa-usd fa-fw"></i> Financeiro <span class="caret"></span>
    </a>
    <ul class="dropdown-menu" role="menu">
        @if (User::allowedCredentials([10], true))
            <li class="{{ Route::currentRouteName()=='financeiroMovimentacao'?'active':'' }}">
                <a href="{{ route('financeiroMovimentacao') }}">
                    <i class="fa fa-exchange fa-fw"></i> Movimentação
                </a>
            </li>
        @endif
        @if (User::allowedCredentials([10, 30], true))
            <li class="{{ Route::currentRouteName()=='financeiroReceber'?'active':'' }}">
                <a href="{{ route('financeiroReceber') }}">
                    <i class="fa fa-plus-square fa-fw"></i> Faturamento Pacientes
                </a>
            </li>
        @endif
        @if (User::allowedCredentials([10], true))
            <li class="{{ Route::currentRouteName()=='financeiroProducao'?'active':'' }}">
                <a href="{{ route('financeiroProducao') }}">
                    <i class="fa fa-user-o fa-fw"></i> Produção Profissionais
                </a>
            </li>
            <li class="divider"></li>
            <li class="{{ Route::currentRouteName()=='financeiroSaldo'?'active':'' }}">
                <a href="{{ route('financeiroSaldo') }}">
                    <i class="fa fa-bar-chart fa-fw"></i> Saldo em contas
                </a>
            </li>
            <?php 
                /*
                <li class="{{ Route::currentRouteName()=='financeiroFluxo'?'active':'' }}">
                    <a href="{{ route('financeiroFluxo') }}">
                        <i class="fa fa-line-chart fa-fw"></i> Fluxo de caixa
                    </a>
                </li>
                */
            ?>
            <li class="{{ Route::currentRouteName()=='financeiroConciliacao'?'active':'' }}">
                <a href="{{ route('financeiroConciliacao') }}">
                    <i class="fa fa-copy fa-fw"></i> Conciliação
                </a>
            </li>
        @endif
    </ul>
</li>
