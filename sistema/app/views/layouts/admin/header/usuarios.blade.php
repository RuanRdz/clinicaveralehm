
<li class="{{ Route::currentRouteName()=='userEdit'?'active':'' }}">
    <a href="{{ route('userEdit', ['id' => Auth::user()->id]) }}" class="inline-block w-64 truncate text-right">
        <i class="fa fa-user-circle-o"></i>
        {{ Auth::user()->fullName }}
    </a>
</li>
<li>
    <a href="{{ route('sair') }}" title="Sair" class="font-bold text-red-700">
        <i class="fa fa-power-off fa-fw"></i> Sair
    </a>
</li>