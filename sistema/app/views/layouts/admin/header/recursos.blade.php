<?php
$menuRecursos = [
    // Clínica
    'agendasituacoes',
    'anamnese',
    'convenios', 
    'conveniotipos',
    'lesoes', 
    'medicos',
    'membros',
    'tratamentotipos', 
    'tratamentosituacoes', 
    // Financeiro
    'bancos', 
    'centrocusto', 
    'contas', 
    'documentos',
    'formapagamento', 
    'fornecedores', 
    'tipodespesa',
];
?>
<li class="dropdown {{ in_array(Request::segment(1), $menuRecursos) ? 'active' : '' }}">
    <a href="#" class="dropdown-toggle" data-toggle="dropdown">
        <i class="fa fa-folder-open-o fa-fw"></i> Recursos <span class="caret"></span>
    </a>
    <ul class="dropdown-menu" role="menu">
       @if (User::allowedCredentials([10], true))
            <li class="{{ Route::currentRouteName()=='users'?'active':'' }}">
                <a href="{{ route('users') }}">
                    <i class="fa fa-user fa-fw"></i> Usuários
                </a>
            </li>
            <li class="divider"></li>
            <li class="{{ Route::currentRouteName()=='medicos'?'active':'' }}">
                <a href="{{route('medicos')}}">
                    <i class="fa fa-user-md fa-fw"></i> Médicos
                </a>
            </li>
            <li class="{{ Route::currentRouteName()=='lesoes'?'active':'' }}">
                <a href="{{route('lesoes')}}">
                    <i class="fa fa-chain-broken fa-fw"></i> Patologias
                </a>
            </li>
            <li class="{{ Route::currentRouteName()=='membros'?'active':'' }}">
                <a href="{{route('membros')}}">
                    <i class="fa fa-male fa-fw"></i> Segmentos
                </a>
            </li>
            <li class="{{ Route::currentRouteName()=='convenios'?'active':'' }}">
                <a href="{{route('convenios')}}">
                    <i class="fa fa-h-square fa-fw"></i> Convênios
                </a>
            </li>
            <li class="divider"></li>
            <li class="{{ Route::currentRouteName()=='conveniotipos'?'active':'' }}">
                <a href="{{route('conveniotipos')}}">
                    <i class="fa fa-puzzle-piece fa-fw"></i> Tipos de convênio
                </a>
            </li>
            <li class="{{ Route::currentRouteName()=='tratamentotipos'?'active':'' }}">
                <a href="{{route('tratamentotipos')}}">
                    <i class="fa fa-puzzle-piece fa-fw"></i> Tipos de tratamento
                </a>
            </li>
            <li class="{{ Route::currentRouteName()=='tratamentosituacoes'?'active':'' }}">
                <a href="{{route('tratamentosituacoes')}}">
                    <i class="fa fa-flag fa-fw"></i> Situações do tratamento
                </a>
            </li>
            <li class="{{ Route::currentRouteName()=='agendasituacoes'?'active':'' }}">
                <a href="{{route('agendasituacoes')}}">
                    <i class="fa fa-flag-o fa-fw"></i> Situações da agenda
                </a>
            </li>
            <li class="{{ Route::currentRouteName()=='textosprontuario'?'active':'' }}">
                <a href="{{route('textosprontuario')}}">
                    <i class="fa fa-file-text-o fa-fw"></i> Gabaritos prontuário
                </a>
            </li>
            <li class="{{ Route::currentRouteName()=='atividadesconfig'?'active':'' }}">
                <a href="{{route('atividadesconfig')}}">
                    <i class="fa fa-edit fa-fw"></i> Parâmetros de atividade 
                </a>
            </li>
            <li class="{{ Route::currentRouteName()=='terminologiauniformeconfig'?'active':'' }}">
                <a href="{{route('terminologiauniformeconfig')}}">
                    <i class="fa fa-edit fa-fw"></i> Terminologia uniforme 
                </a>
            </li>
            <li class="divider"></li>
            <li class="{{ Route::currentRouteName()=='fornecedores'?'active':'' }}">
                <a href="{{ route('fornecedores') }}">
                    <i class="fa fa-folder-open-o fa-fw"></i> Fornecedores
                </a>
            </li>
            <li class="divider"></li>
            <li class="{{ Route::currentRouteName()=='contas'?'active':'' }}">
                <a href="{{ route('contas') }}">
                    <i class="fa fa-folder-open-o fa-fw"></i> Contas
                </a>
            </li>
            <li class="{{ Route::currentRouteName()=='centrocusto'?'active':'' }}">
                <a href="{{ route('centrocusto') }}">
                    <i class="fa fa-folder-open-o fa-fw"></i> Plano de contas
                </a>
            </li>
            <li class="{{ Route::currentRouteName()=='tipodespesa'?'active':'' }}">
                <a href="{{ route('tipodespesa') }}">
                    <i class="fa fa-folder-open-o fa-fw"></i> Centro de custo
                </a>
            </li>
            <li class="{{ Route::currentRouteName()=='bancos'?'active':'' }}">
                <a href="{{ route('bancos') }}">
                    <i class="fa fa-folder-open-o fa-fw"></i> Bancos
                </a>
            </li>
            <li class="{{ Route::currentRouteName()=='documentos'?'active':'' }}">
                <a href="{{ route('documentos') }}">
                    <i class="fa fa-folder-open-o fa-fw"></i> Documentos
                </a>
            </li>
            <li class="{{ Route::currentRouteName()=='formapagamento'?'active':'' }}">
                <a href="{{ route('formapagamento') }}">
                    <i class="fa fa-folder-open-o fa-fw"></i> Formas de pagamento
                </a>
            </li>
            <li class="divider"></li>
            <li class="{{ Route::currentRouteName()=='workspaces'?'active':'' }}">
                <a href="{{ route('workspaces') }}">
                    <i class="fa fa-map-marker fa-fw"></i> Áreas de trabalho
                </a>
            </li>
            <li class="{{ Route::currentRouteName()=='sistema'?'active':'' }}">
                <a href="{{ route('sistema') }}">
                    <i class="fa fa-file-text-o fa-fw"></i> Informações da empresa
                </a>
            </li>
            <li class="{{ Route::currentRouteName()=='cidade'?'active':'' }}">
                <a href="{{ route('cidade') }}">
                    <i class="fa fa-globe fa-fw"></i> Cadastro de cidades
                </a>
            </li>
        @endif
    </ul>
</li>
