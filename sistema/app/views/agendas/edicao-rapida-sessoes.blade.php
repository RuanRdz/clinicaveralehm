
{{ Former::framework('TwitterBootstrap3') }}
{{ Former::populate($agenda) }}
{{
    Former::inline_open()
        ->action(route('agendasUpdateEdicaoRapidaSessoes', ['tratamento_id' => $tratamento->id]))
        ->id('form-edicao-rapida_sessoes')
        ->secure()
}}

<input type="hidden" id="terapeuta_id" value="{{$tratamento->terapeuta_id}}">

<div class="row">
	<div class="col-xs-16 col-sm-4 col-md-3 col-lg-3">
		<div style="width: 80px; height: 80px;">
			<div 
				class="circular-crop" 
				style="background-image: url({{ $tratamento->paciente->foto }})">
			</div>
		</div>
	</div>
	<div class="col-xs-16 col-sm-12 col-md-13 col-lg-13">
		<div class="mt-8 text-xl">
			<strong>{{ $tratamento->paciente->nome }}</strong>
		</div>
        <div class="mt-4 text-lg">
            Sessões tratamento #<strong>{{$tratamento->id}}</strong>
        </div>
	</div>
</div>

<hr />

<div class="bg-gray-100 p-3 mb-3">
    <div class="row">
        <div class="col-md-9">
                <div class="bg-white shadow-md">
                    <table class="table table-sm">
                        <tr>
                            <th>Sessão</th>
                            <th>Data</th>
                            <th>Início</th>
                            <th>Fim</th>
                            <th>Situação</th>
                        </tr>
                        @foreach($agenda as $item)
                            @if($item->allowEdit())
                                <tr>
                                    <td>
                                        <strong 
                                            class="text-primary text-xl leading-loose">
                                            {{$item->sessao}}
                                        </strong>
                                    </td>
                                    <td>
                                        {{ Former::text("data_sessao[{$item->id}]")
                                            ->class('form-control data_sessao_edicao_rapida datepicker')
                                            ->style('width: 100px;')
                                            ->value($item->data_sessao) }}
                                    </td>
                                    <td>
                                        {{ Former::select("inicio[{$item->id}]")
                                            ->options(horarios())
                                            ->class('form-control select_inicio')
                                            ->value($item->inicio) }}
                                    </td>
                                    <td>
                                        {{ Former::select("fim[{$item->id}]")
                                            ->options(horarios())
                                            ->class('form-control select_fim')
                                            ->value($item->fim) }}
                                    </td>
                                    <td>
                                        {{ Former::select("agendasituacao_id[{$item->id}]")
                                            ->options(Agendasituacao::lists('nome', 'id'))
                                            ->class('form-control')
                                            ->value($item->agendasituacao_id) }}
                                    </td>
                                </tr>
                            @else 
                                <tr class="text-gray-500">
                                    <td>
                                        <strong 
                                            class="text-xl leading-loose">
                                            {{$item->sessao}}
                                        </strong>
                                    </td>
                                    <td>
                                        <div class="py-3">{{$item->data_sessao}}</div>
                                    </td>
                                    <td>
                                        <div class="py-3">{{$item->inicio}}</div>
                                    </td>
                                    <td>
                                        <div class="py-3">{{$item->fim}}</div>
                                    </td>
                                    <td>
                                        <div class="py-3">{{$item->agendasituacao->nome}}</div>
                                    </td>
                                </tr>
                            @endif
                        @endforeach
                    </table>
                </div>
        </div>
        <div class="col-md-7">
            <div id="consulta-sessoes"></div>
        </div>
    </div>
</div>

<div class="text-right">
    <button type="button" class="btn btn-default" data-dismiss="modal">Fechar</button>
    {{ Former::submit('Salvar')->class('btn btn-primary') }}
</div>

{{ Former::close() }}