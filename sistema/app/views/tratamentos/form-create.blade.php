@extends('layouts.admin.template')

@section('head')
	@parent
	<title>Sistema</title>
@stop

@section('main-panel-heading')
	@parent
	<ol class="breadcrumb">
		<li>{{ link_to_route('painel', $paciente->nome, ['id' => $paciente->id]) }}</li>
		<li class="active">Novo Tratamento</li>
	</ol>
@stop

@section('content')

	<div class="row">
		<div class="col-xs-16 col-sm-12 col-sm-offset-2 col-md-8 col-md-offset-4 col-lg-6 col-lg-offset-5">
			{{ Former::framework('TwitterBootstrap3') }}
			{{ Former::populate($tratamento) }}
			{{ Former::populateField('paciente_id', $paciente->id) }}
			{{ Former::vertical_open()
				->action($action)
				->rules($rules)
                ->autocomplete('off')
				->secure() 
            }}
			{{ Former::hidden('paciente_id')->id('paciente_id') }}

			<h4><strong>{{ $paciente->nome }}</strong></h4>
			<br />

			<div class="panel panel-default">
				<div class="panel-heading">
                    <span class="text-2xl text-gray-600">Novo Tratamento</span></div>
				<div class="panel-body">
					{{ Former::select('workspace_id')
						->options($workspaces)
						->label('Área de trabalho')
                        ->id('combobox_workspace')
                        ->class('form-control') 
                    }}
					{{ Former::select('terapeuta_id')
						->options($terapeutas)
						->id('combobox_terapeuta')
                        ->label('Terapeuta Ocupacional / Fisioterapeuta') 
                        ->class('form-control')
                    }}
					{{ Former::select('tratamentotipo_id')
						->options($tratamentotipos)
                        ->label('Tipo de tratamento') 
                        ->class('form-control')
                    }}
					{{ Former::select('convenio_id')
						->options($convenios)
                        ->label('Convênio / Serviço') 
                        ->class('form-control')
                    }}
				</div>
			</div>
			
			<!-- <div class="panel panel-default">
				<div class="panel-heading">Prioridade de Complexidade</div>
				<div class="panel-body">
					{{ Former::select('complexidade_id')
						->options($complexidades)
						->label('Complexidade') }}
				</div>
			</div> -->

            <div class="text-right">
                {{ Former::submit('Salvar')->class('btn btn-primary') }}
            </div>

			{{ Former::close() }}
		</div>
	</div>
@stop
