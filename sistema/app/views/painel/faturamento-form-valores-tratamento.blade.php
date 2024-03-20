
{{ Former::framework('TwitterBootstrap3') }}
{{ Former::populate($tratamento) }}
{{ Former::populateField('tratamento_id', $tratamento->id) }}
{{
    Former::vertical_open()
    ->secure()
    ->attributes(['ng-submit' => "submitForm('$action')", 'autocomplete' => 'off'])
    ->rules([
        'valor_sessao' => 'required',
        'total' => 'required',
    ]);
}}
    <div class="form-theme-default">
        <div class="form-heading">
            Alteração de valores do tratamento
            <div class="font-bold text-gray-700 text-2xl">
                {{ $tratamento->paciente->nome }}
            </div>
            <div class="text-gray-600">
                <span class="mr-4">Tratamento</span>
                #<strong class="mr-4 text-blue-500">{{ $tratamento->id }}</strong>
                <span>{{ $tratamento->created_at }}</span>
            </div>
            <div>
                <span class="text-gray-600" >Profissional</span>
                <strong class="mr-4 text-blue-500">{{ $tratamento->terapeuta->full_name }}</strong>
            </div>
        </div>
        <div class="form-body">
            <div class="row">
                <div class="col-md-4 col-md-offset-4">
                    {{ Former::text('valor_sessao')->value($tratamento->valor_sessao)->label('Valor da sessão')->class('form-control')->pattern('([0-9]{1,3}\.)?[0-9]{1,3},[0-9]{2}$') }}
                </div>
                <div class="col-md-4">
                    {{ Former::text('total')->value($tratamento->total)->label('Valor total')->class('form-control')->pattern('([0-9]{1,3}\.)?[0-9]{1,3},[0-9]{2}$') }}
                </div>
            </div>
        </div>
        <div class="form-footer">
            <div class="col text-right">
                <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
                {{ Former::submit('Salvar')->class('btn btn-primary') }}
            </div>
        </div>
    </div>
{{ Former::close() }}
