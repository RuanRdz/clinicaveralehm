
<!-- Static navbar -->
<div class="navbar navbar-default navbar-static-top shadow-md border-0 pt-2" role="navigation" style="position:relative; z-index:99">
    <div class="container-fluid">
        <div class="navbar-header">
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target=".navbar-collapse">
                <i class="fa fa-bars fa-2x"></i>
            </button>
            <div>
                <a href="{{ route('dashboard') }}">
                    {{
                        HTML::image (
                            asset('img/vera-lehm-dashboard-logotype.png'),
                            '',
                            array('style' => 'height: 50px;')
                        )
                    }}
                </a>
            </div>
        </div>
        <div class="navbar-collapse collapse bg-white">
            <div
                data-action="{{ route('pacientesSearch') }}"
                id="formSearchPaciente"
                class="navbar-form navbar-left"
                role="search">
                <div class="input-group w-64 m-0 p-0">
                    <input
                        class="form-control m-0 p-0"
                        data-model="user"
                        name="term"
                        type="text"
                        placeholder="Buscar paciente"
                    >
                    <div class="input-group-btn" title="Novo paciente">
                        <a class="btn btn-primary" href="{{ route('pacientesCreate') }}">
                            <i class="fa fa-plus"></i> Paciente
                        </a>
                    </div>
                </div>
            </div>
            <ul class="nav navbar-nav">
                {{ View::make('layouts.admin.header.clinica') }}
                @if (User::allowedCredentials([10, 30], true))
                    {{ View::make('layouts.admin.header.financeiro') }}
                    {{ View::make('layouts.admin.header.recursos') }}
                @endif
                {{ View::make('layouts.admin.header.workspace') }}
            </ul>
            <ul class="nav navbar-nav navbar-right">                
                {{ View::make('layouts.admin.header.usuarios') }}
            </ul>
        </div><!--/.nav-collapse -->
    </div>
</div>
