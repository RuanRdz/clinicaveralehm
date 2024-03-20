<div class="btn-group">
    <a
        class="btn btn-default {{ Route::currentRouteName()=='relatorio'?'active':'' }}"
        href="{{ route('relatorio', ['id' => $tratamento->id]) }}">
        <i class="fa fa-file-text-o fa-fw"></i> Relatório
    </a>
    <button
        type="button"
        class="btn btn-default dropdown-toggle"
        data-toggle="dropdown"
        aria-haspopup="true"
        aria-expanded="false"
        title="Protocolos">
        <span class="caret"></span>
        <span class="sr-only">Toggle Dropdown</span>
    </button>
    <ul class="dropdown-menu">
        <li class="{{ Route::currentRouteName()=='relatorioEdit'?'active':'' }}">
            <a href="{{ route('relatorioEdit', ['id' => $tratamento->id]) }}">
                <i class="fa fa-pencil fa-fw"></i> Informações e Configurações
            </a>
        </li>
        <li role="separator" class="divider"></li>
        <li class="{{ Route::currentRouteName()=='mapeamentosensorialEdit'?'active':'' }}">
            <a href="{{ route('mapeamentosensorialEdit', ['id' => $tratamento->id]) }}">
                <i class="fa fa-pencil fa-fw"></i> Mapeamento Sensorial
            </a>
        </li>
        <li class="{{ Route::currentRouteName()=='tabelaforcaIndex'?'active':'' }}">
            <a href="{{ route('tabelaforcaIndex', ['id' => $tratamento->id]) }}">
                <i class="fa fa-pencil fa-fw"></i> Tabela de Força - Jamar
            </a>
        </li>
        <li class="{{ Route::currentRouteName()=='testeforcatratamentosIndex'?'active':'' }}">
            <a href="{{ route('testeforcatratamentosIndex', ['id' => $tratamento->id]) }}">
                <i class="fa fa-pencil fa-fw"></i> Teste de Força Muscular
            </a>
        </li>
        <li class="{{ Route::currentRouteName()=='amplitudetratamentosIndex'?'active':'' }}">
            <a href="{{ route('amplitudetratamentosIndex', ['id' => $tratamento->id]) }}">
                <i class="fa fa-pencil fa-fw"></i> Amplitude de Movimento
            </a>
        </li>
        <li class="{{ Route::currentRouteName()=='avdsEdit'?'active':'' }}">
            <a href="{{ route('avdsEdit', ['id' => $tratamento->id]) }}">
                <i class="fa fa-pencil fa-fw"></i> AVD's
            </a>
        </li>
        <li class="{{ Route::currentRouteName()=='terminologiauniformeEdit'?'active':'' }}">
            <a href="{{ route('terminologiauniformeEdit', ['id' => $tratamento->id]) }}">
                <i class="fa fa-pencil fa-fw"></i> Terminologia Uniforme
            </a>
        </li>
    </ul>
</div>
