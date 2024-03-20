@extends('layouts.admin.template')

@section('head')
	@parent
	<title>Sistema</title>
@stop

@section('main-panel-heading')
	@parent
	<ol class="breadcrumb">
		<li>{{ link_to_route('painel', $paciente->nome, ['id' => $paciente->id, 'id2' => $prontuario->tratamento_id, '#tab-prontuario']) }}</li>
		<li class="active">Prontuário</li>
	</ol>
@stop


@section('content')
	
	{{ 
		View::make('pacientes.profile-header')
			->with(array('title' => 'Prontuário', 'paciente' => $paciente))
	}}
	
	<div class="row">
		<div class="col-xs-16 col-md-12 col-md-offset-2 col-lg-10 col-lg-offset-3">
			<div class="panel panel-default">
				<div class="panel-heading">
					Edição Prontuário
				</div>
				<div class="panel-body">	
            
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

                    <div ng-controller="ProntuarioFormEditController">
                        <div class="mt-8">
                            <div id="data_conteudo">{{$prontuario->descricao ? $prontuario->descricao : ''}}</div>
                            <textarea 
                                name="descricao" 
                                ui-tinymce="tinymceOptions"
                                ng-model="tinymceHtml"
                            ></textarea>
                        </div>
                    </div>

                    {{ Former::close() }}

				</div>
			</div>
		</div>
	</div>

@stop
