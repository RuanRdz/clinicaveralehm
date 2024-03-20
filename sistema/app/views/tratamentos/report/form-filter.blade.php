
<div 
    class="alert alert-warning no-print js-show-report-form-configs"
    style="display: none;">

    <p style="margin-bottom: 5px;">Configurações Relatório</p>

	{{Form::open([
		'route' => 'reportUpdate',
		'role' => 'form',
		'class' => 'form form-inline'
	])}}
    
	{{ Form::hidden('tratamento_id', $treatment->id) }}

        <div class="row">
            <div class="col-xs-16 col-md-12">
                <p>
                    <strong>Campo informativo sessões e datas:</strong> 
                    <small>(Deixar em branco para usar Padrão)</small>
                    <input
                        type="text"
                        name="info_sessoes"
                        value="{{ $treatment->info_sessoes }}"
                        class="form-control"
                        style="width: 100%;"
                    />
                </p>

                <p>
                    <strong>Padrão</strong>: Compareceu a {{ $num_sessoes }} sessões de Terapia Ocupacional
                    no período de {{ $sessao_inicial }} a {{ $sessao_final }}
                </p>
            </div>
            <div class="col-xs-16 col-md-4 text-center">
                {{ Form::submit('Salvar', ['class' => 'btn btn-warning']) }}
            </div>
        </div>

	{{ Form::close() }}

</div>
