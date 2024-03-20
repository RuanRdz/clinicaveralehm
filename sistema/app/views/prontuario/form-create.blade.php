
{{ Former::framework('TwitterBootstrap3') }}
{{ Former::populate($prontuario) }}
{{
	Former::vertical_open()
	->action($action)
	->secure()
	->rules([
		'terapeuta_id' 	 => 'required',
		'descricao' 	 => 'required',
		'dataprontuario' => 'required',
	])
}}
{{ Former::hidden('paciente_id') }}
{{ Former::hidden('tratamento_id') }}

<div class="text-right">
    <div class="flex justify-center">
        <div class="form-group">
            <div class="input-group">
                <div class="input-group-addon">
                    Data
                </div>
                {{ Former::text('dataprontuario')
                    ->id('dataprontuario')
                    ->class('form-control datepicker')
                    ->style('width: 120px;')
                    ->label('') 
                }}
            </div>
        </div>
        <div class="pl-4">
            {{ Former::actions(Former::submit('Salvar')->class('btn btn-primary'))->class('text-right') }}
        </div>
    </div>
</div>

<div class="mt-8">
    <textarea 
        name="descricao" 
        ui-tinymce="tinymceOptions"
        ng-model="tinymceHtml"
    >{{$prontuario->descricao ? $prontuario->descricao : ''}}</textarea>
</div>

{{ Former::close() }}
