<?php
$menuClinica = [
    'agendas', 
    'tratamentos', 
    'pacientes'
];
?>
<li class="dropdown {{ in_array(Request::segment(1), $menuClinica) ? 'active' : '' }}">
    <a href="#" class="dropdown-toggle" data-toggle="dropdown">
        <i class="fa fa-stethoscope fa-fw"></i> Clínica <span class="caret"></span>
    </a>
    <ul class="dropdown-menu" role="menu">
        @if (User::allowedCredentials([10, 20, 30], true))
            <li class="{{ Route::currentRouteName()=='agendas'?'active':'' }}">
                <a href="{{route('agendas')}}">
                    <i class="fa fa-calendar fa-fw"></i> Horários do dia
                </a>
            </li>
            <li class="{{ Route::currentRouteName()=='agendasControle'?'active':'' }}">
                <a href="{{route('agendasControle')}}">
                    <i class="fa fa-gear fa-fw"></i> Agenda
                </a>
            </li>
            <li class="{{ Route::currentRouteName()=='tratamentos'?'active':'' }}">
                <a href="{{route('tratamentos')}}">
                    <i class="fa fa-gear fa-fw"></i> Tratamentos
                </a>
            </li>
        @endif
        @if (User::allowedCredentials([10, 30], true))
            <li class="{{ Route::currentRouteName()=='pacientes'?'active':'' }}">
                <a href="{{ route('pacientes') }}">
                    <i class="fa fa-user fa-fw"></i> Pacientes
                </a>
            </li>  
        @endif
        <li class="divider"></li>
        <li>
            <a href="{{ route('agendasCreateBloqueio') }}" id="btn-agenda-bloquear">
                <i class="fa fa-ban fa-fw"></i> Bloquear
            </a>
        </li>
        <li>
            <a href="{{ route('agendasCreateAgendamento') }}" id="btn-agenda-agendamento">
                <i class="fa fa-edit fa-fw"></i> Pré-agendamento
            </a>
        </li>
    </ul>
</li>
