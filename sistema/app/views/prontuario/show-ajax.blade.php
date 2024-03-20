
<div class="modal-body">
    {{ 
        View::make('pacientes.profile-header')
            ->with(array('title' => 'Prontuário', 'paciente' => $paciente))
    }}
    <div class="panel panel-default">
        <div class="panel-heading">
            <div class="row">
                <h3 class="m-0">{{ $prontuario->dataprontuario }}</h3>
            </div>
        </div>
        <div class="panel-body">
            <div class="text-justify">{{ nl2br($prontuario->descricao) }}</div>
        </div>
        <div class="panel-body">		
            {{ View::make('layouts.admin.update-assinatura')->with(array('user' => $prontuario))->render() }}
            {{ View::make('layouts.admin.update-info')->with(array('user' => $prontuario))->render() }}
        </div>
    </div>
</div>
<div class="modal-footer">
    <button type="button" class="btn btn-default" data-dismiss="modal">Fechar</button>
</div>