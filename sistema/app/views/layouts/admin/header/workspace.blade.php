
<?php 
$workspaces = User::workspacesVisiveisPorUsuario()->lists('nome', 'id');
$workspaceSelecionado = 'Espaço';
if (isset($workspaces[Session::get('workspace_id')])) {
    $workspaceSelecionado = $workspaces[Session::get('workspace_id')];
}
?>

<li class="dropdown">
    <a href="#" class="dropdown-toggle" data-toggle="dropdown">
        <i class="fa fa-map-marker fa-fw"></i>
        {{$workspaceSelecionado}} <span class="caret"></span>
    </a>
    <ul class="dropdown-menu" role="menu">
        @foreach ($workspaces as $id => $option)
            <li class="{{$id == Session::get('workspace_id') ? 'active' : ''}}">
                <a href="{{ route('setCurrentWorkspace', ['id' => $id]) }}" class="setCurrentWorkspace">
                    {{ $option }}
                </a>
            </li>
        @endforeach
        @if (count($workspaces) == 0)
            <li>
                <a href="{{route('workspaces')}}">Definir área de trabalho</a>
            </li>
        @endif
    </ul>
</li>

<li class="{{ Request::segment(1)=='inbox'?'active':'' }}" title="Comunicação">
    <a href="{{ route('inbox') }}">
        <i class="fa fa-commenting-o fa-fw fa-lg"></i>
        <?php $ct = Tarefa::recebidasNaoLidas();?>
        <span class="badge text-white bg-red-600">{{ $ct > 0 ? $ct : '' }}</span>
    </a>
</li>