
<div class="row">

	<div class="col-xs-16 col-sm-4 col-md-3 col-lg-3">
		<div style="width: 80px; height: 80px;">
			<div 
				class="circular-crop" 
				style="background-image: url({{ $agenda->tratamento->paciente->foto }})">
			</div>
		</div>
	</div>

	<div class="col-xs-16 col-sm-12 col-md-13 col-lg-13">
		<div class="mt-8 text-xl">
			<strong>{{ $agenda->tratamento->paciente->nome }}</strong>
		</div>
		<div class="mt-4 text-lg">
			Sessão: 
			<strong class="text-primary">{{ $agenda->sessao }}</strong>

			<span class="ml-8">
				Complexidade: 
				@if ($complexidadeAtual)
					<div 
						class="formAgendaComplexidade"
						style="color: {{$complexidadeAtual['color']}}; background: {{$complexidadeAtual['bg_color']}}"
						>{{$complexidadeAtual['grau']}}</div>
				@else
					<div class="formAgendaComplexidade">-</div>
				@endif
			</span>
		</div>
	</div>
</div>

<hr />

{{ Former::framework('TwitterBootstrap3') }}
{{ Former::populate($agenda) }}
{{
	Former::inline_open()
	->action(route('agendasUpdate', ['id' => $agenda->id]))
	->rules($rules)
	->id('form-agendar')
	->secure()
}}
    {{ Former::hidden('terapeuta_id')->value($agenda->tratamento->terapeuta_id) }}

	<div class="row">

		<div class="col-xs-16 col-md-9">

            <div class="mb-8">
                <div class="form-group">
                    <div class="input-group">
                        <div class="input-group-addon">Data</div>
                        {{
                        Former::text('data_sessao')
                            ->class('form-control datepicker')
                            ->id('data_sessao')
                            ->style("width: 120px !important")
                        }}
                    </div>
                </div>
                &nbsp;&nbsp;&nbsp;

                <div class="form-group">
                    <div class="input-group">
                        <div class="input-group-addon"><i class="fa fa-clock-o"></i> Inicial</div>
                        {{
                        Former::select('inicio')
                            ->options(horarios())
                            ->class('form-control select_inicio')
                        }}
                    </div>
                </div>
                &nbsp;&nbsp;&nbsp;
                
                <div class="form-group">
                    <div class="input-group">
                        <div class="input-group-addon"><i class="fa fa-clock-o"></i> Final</div>
                        {{
                        Former::select('fim')
                            ->options(horarios())
                            ->class('form-control select_fim')
                        }}
                    </div>
                </div>
            </div>

			<!-- <div class="row">
				<div class="col-xs-16">
					<div style="padding-top: 25px; padding-bottom: 25px;">
						@include('workspaces.dropdown-profissional', array(
							'terapeutas' => $terapeutas, 
							'user_id' => $agenda->tratamento->terapeuta_id
						))
					</div>
				</div>
			</div> -->

            <div class="form-group mb-8">
                <div class="input-group">
                    <div class="input-group-addon">Alterar Complexidade</div>
                    {{
                    Former::select('complexidade_id')
                        ->options($complexidades)
                        ->class('form-control')
                    }}
                </div>
            </div>

		</div>

		<div class="col-xs-16 col-md-4">
			
			<div class="form-group">
				<label>Situação</label>
				@foreach(Agendasituacao::lists('nome', 'id') as $id => $nome)
					<div class="radio" style="display: block; padding: 3px 0;">
						<label>
							<input 
								type="radio" 
								name="agendasituacao_id" 
								value="{{$id}}"
								{{ $agenda->agendasituacao_id == $id ? 'checked="checked"' : '' }}> 
							@if($agenda->agendasituacao_id == $id)
								<strong>{{$nome}}</strong>
							@else
								{{$nome}}
							@endif
						</label>
					</div>
				@endforeach
			</div>
            
            @if(User::allowedCredentials([10, 30], true))
                <div class="checkbox" style="margin-top: 10px; display: block;">
                    <?php 
                    switch ($checkUltimaSessaoAtendimentos) {
                        case 'sessoes-concluidas':
                            ?>
                            <div 
                                style="color: #fff; background-color: #5CB85C; padding: 5px;"
                                title="Todas as sessões anteriores foram atendidas">
                                @if($agenda->tratamento->tratamentosituacao_id == 2)
                                    <i class="fa fa-check fa-lg"></i> 
                                    Tratamento concluído
                                @else 
                                    {{ 
                                        Former::checkbox('concluir_tratamento')
                                            ->text(' Concluir Tratamento?') 
                                    }}
                                @endif
                            </div>
                            <?php
                            break;
                        case 'sessoes-pendentes':
                            ?>
                            <div 
                                style="color: #fff; background-color: #DA4E51; padding: 5px;"
                                title="É última sessão mas nem todas foram atendidas">
                                {{ 
                                    Former::checkbox('concluir_tratamento')
                                    ->text(' Concluir Tratamento?') 
                                }}
                                <i class="fa fa-exclamation-triangle fa-lg"></i>
                            </div>
                            <?php
                            break;
                    }
                    ?>
                </div>
            @endif
		</div>

		<div class="col-xs-16 col-md-3 text-right">
            <div>
                <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
                {{ Former::submit('Salvar')->class('btn btn-primary') }}
            </div>
            @if((Auth::user()->isAdmin || $agenda->agendasituacao_id == 1) && User::allowedCredentials([10, 30], true))
                <div class="mt-12">
                    <a 
                        href="{{ route('agendasDestroy', ['id' => $agenda->id]) }}" 
                        class="btn btn-default confirm-destroy">
                        <span class="text-red-500">Excluir Sessão</span>
                    </a>
                </div>
            @endif
		</div>

	</div>
{{ Former::close() }}

<hr />
<div id="consulta-sessoes"></div>

<hr />
{{ View::make('layouts.admin.update-info')->with(array('user' => $agenda))->render() }}
