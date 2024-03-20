@extends('layouts.admin.template')

@section('head')
	@parent
	<title>Sistema</title>
@stop

@section('main-panel-heading')
	@parent
	<ol class="breadcrumb">
		<li>{{ link_to_route('painel', $tratamento->paciente->nome, ['id' => $tratamento->paciente->id, 'id2' => $tratamento->id]) }}</li>
		<li class="active">Editar</li>
	</ol>
@stop

@section('content')

    <?php $disabled = !$tratamento->liberado_para_edicao;?>

	<div style="position: relative; height: 80px; margin-bottom: 15px;">
		<div style="width: 80px;">
			<div class="circular-crop" style="background-image: url({{ $tratamento->paciente->foto }});"></div>
		</div>
		<div style="position: absolute; top: 25px; left: 90px;">
			<p>Tratamento</p>
			<h4>{{ $tratamento->paciente->nome }}</h4>
		</div>
	</div>

    <div ng-controller="ListRecursos">
        {{ Former::framework('TwitterBootstrap3') }}
        {{ Former::populate($tratamento) }}
        {{ Former::populateField('lesao', $lesao) }}
        {{ Former::populateField('membro', $membro) }}
        {{ Former::populateField('medico', $medico) }}
        {{ Former::populateField('convenio', $convenio) }}
        {{
            Former::vertical_open()
            ->action($action)
            ->autocomplete('off')
            ->rules($rules)
            ->secure();
        }}
    
        <div class="row">
            <div class="col-xs-16 col-sm-16 col-md-9 col-lg-9">
                <div class="panel panel-default">
                    <div class="panel-heading">Clínico</div>
                    <div class="panel-body">
                        {{ Former::select('tratamentotipo_id')
                            ->options($tratamentotipos)
                            ->label('Tipo de tratamento')
                            ->class('form-control')
                            ->disabled($disabled) }}
    
                        <div class="row">
                            <div class="col-xs-16 col-sm-12 col-md-12 col-lg-13">
                                {{ Former::text('lesao')
                                    ->id('lesao')
                                    ->class('form-control') 
                                    ->label('Lesão'.$button_fk_lesao)
                                    ->placeholder('Digite para pesquisar')
                                    ->disabled($disabled)
                                }}
                                {{ Former::hidden('lesao_id')->id('lesao_id')->disabled($disabled) }}
                            </div>
                            <div class="col-xs-6 col-sm-4 col-md-4 col-lg-3">
                                {{ Former::text('data_lesao')->class('form-control datepicker')->label('Data da lesão')->disabled($disabled) }}
                            </div>
                        </div>
    
                        <div class="row">
                            <div class="col-xs-16 col-sm-12 col-md-12 col-lg-13">
                                {{ Former::text('membro')
                                    ->id('membro')
                                    ->class('form-control')
                                    ->label('Segmento'.$button_fk_membro)
                                    ->placeholder('Digite para pesquisar')
                                    ->disabled($disabled)
                                }}
                                {{ Former::hidden('membro_id')->id('membro_id')->disabled($disabled) }}
                            </div>
                            <div class="col-xs-16 col-sm-4 col-md-4 col-lg-3">
                                {{ Former::select('membro_tipo')
                                    ->options(Membro::$tipoMembro)
                                    ->label('Membro')
                                    ->class('form-control') 
                                    ->disabled($disabled)
                                }}
                            </div>
                        </div>
    
                        <div class="row">
                            <div class="col-xs-16 col-sm-6 col-md-5">
                                {{ Former::select('lesao_tratamento')
                                    ->options(Lesao::$opcoesTratamentoLesao)
                                    ->label('Conduta Tratamento')
                                    ->class('form-control')
                                    ->disabled($disabled)
                                }}
                            </div>
                            <div class="col-xs-6 col-sm-4 col-md-3">
                                {{ Former::text('data_cirurgia')->class('form-control datepicker')->label('Data da cirurgia')->disabled($disabled) }}
                            </div>
                            <div class="col-xs-16 col-sm-6 col-md-8">
                                {{ Former::text('tecnica_cirurgica')->class('form-control')->label('Técnica cirúrgica')->disabled($disabled) }}
                            </div>
                        </div>
    
                        {{ Former::textarea('observacoes')
                            ->rows(3)
                            ->label('Observações <small style="font-weight: normal;">(Uso interno)</small>') 
                            ->class('form-control')
                        }}
                    </div>
                </div>
            </div>
            <div class="col-xs-16 col-sm-16 col-md-7 col-lg-7">
                <div class="panel panel-default">
                    <div class="panel-heading">Administrativo</div>
                    <div class="panel-body">
                        {{ Former::text('medico')
                            ->id('medico')
                            ->class('form-control')
                            ->label('Médico'.$button_fk_medico)
                            ->placeholder('Digite para pesquisar')
                            ->disabled($disabled)
                        }}
                        {{ Former::hidden('medico_id')->id('medico_id')->disabled($disabled) }}
                        {{ Former::text('convenio')
                            ->id('convenio')
                            ->class('trigger_dados_convenio form-control')
                            ->label('Convênio / Serviço'.$button_fk_convenio)
                            ->placeholder('Digite para pesquisar')
                            ->disabled($disabled)
                            ->help('Ao alterar o Convênio / Serviço, os valores serão redefinidos')
                        }}
                        {{ Former::hidden('convenio_id')->id('convenio_id')->disabled($disabled) }}
                    </div>
                </div>
                <div class="panel panel-default">
                    <div class="panel-body">
                        <div class="row">
                            <div class="col-xs-16 col-sm-5 col-md-6 col-lg-7">
                                {{
                                Former::select('workspace_id')
                                    ->options($workspaces)
                                    ->label('Área de trabalho')
                                    ->id('combobox_workspace')
                                    ->class('form-control')
                                    ->disabled($disabled)
                                }}
                            </div>
                            <div class="col-xs-16 col-sm-11 col-md-10 col-lg-9">
                                {{
                                Former::select('terapeuta_id')
                                    ->options($terapeutas)
                                    ->id('combobox_terapeuta')
                                    ->label('Profissional')
                                    ->class('form-control')
                                    ->disabled($disabled)
                                }}
                            </div>
                        </div>
                    </div>
                </div>
                <div class="panel panel-default">
                    <div class="panel-heading">
                        {{ Former::select('tratamentosituacao_id')
                            ->options(Tratamentosituacao::lists('nome', 'id'))
                            ->label('Situação do Tratamento') 
                            ->class('form-control')
                            ->disabled($disabled)
                        }}
                    </div>
                </div>
            </div>
        </div>

        <div class="bg-gray-200 p-2">
            <div class="row">
                <div class="col-xs-8">
                    @if ($tratamento->id)
                        <a 
                            class="btn btn-default confirm-destroy" 
                            href="{{ route('tratamentosDestroy', ['id' => $tratamento->id]) }}">
                            <span class="text-danger">
                                <i class="fa fa-trash fa-fw fa-lg"></i> 
                                Excluir Tratamento
                            </span>
                        </a>
                        <button 
                            type="submit"
                            name="duplicate_submit"
                            class="btn btn-info confirm-duplicate">
                            <i class="fa fa-copy fa-fw fa-lg"></i> 
                            Duplicar Tratamento
                        </button>
                    @endif							
                </div>
                <div class="col-xs-8 col-sm-4 col-sm-offset-4 text-right">
                    <a 
                        class="btn btn-default"
                        href="{{ route('painel', ['id' => $tratamento->paciente->id, 'id2' => $tratamento->id]) }}">
                        <i class="fa fa-times fa-fw fa-lg"></i>
                        Cancelar Edição
                    </a>
                    <button 
                        type="submit"
                        name="update_submit"
                        class="btn btn-primary">
                        <strong>Salvar</strong>
                    </button>
                </div>
            </div>
        </div>

        {{ Former::close() }}
    </div>

    <div class="text-center">
        {{ View::make('layouts.admin.update-info')->with(array('user' => $tratamento))->render() }}
    </div>

@stop
