@extends('layouts.admin.template')

@section('head')
	@parent
	<title>Sistema</title>
@stop

@section('main-panel-heading')
	@parent
	<ol class="breadcrumb">
		<li><a href="{{ route('agendas') }}">Horários do Dia</a></li>
		@if(null != $paciente->id)
			<li>
				<a href="{{ route('painel', ['id' => $paciente->id]) }}">
					{{ $paciente->nome }}
				</a>
			</li>
		@endif
		<li class="active">Cadastro</li>
	</ol>
@stop

@section('content')

    <div class="no-print text-right">
        <a
            href="{{ route('pacientesShow', ['id' => $paciente->id]) }}"
            class="btn btn-default mb-1">
            <i class="fa fa-print"></i> Visualizar Impressão
        </a>
    </div>

	{{ Former::framework('TwitterBootstrap3') }}
	{{ Former::populate($paciente) }}
	{{ Former::populateField('cidade', $paciente_cidade) }}
	{{
		Former::vertical_open_for_files()
		->action($action)
		->method('POST')
        ->autocomplete('off')
		->secure()
		->rules($paciente::$rules)
    }}
	<div class="row" style="margin-top: 20px;">
		<div class="col-xs-8 col-xs-offset-4 col-sm-5 col-sm-offset-6 col-md-3 col-md-offset-0 col-lg-2 col-lg-offset-0 text-center">
			<div class="mb-4">
				<div id="foto" class="circular-crop" style="background-image: url({{ $paciente->foto }})"></div>
			</div>
			<div class="mb-12">
				<input id="upload_foto" type="file" name="foto" style="display: none;" accept="image/*;capture=camera"/>
				<input id="delete_foto" type="hidden" name="delete_foto">

				<a href="#" id="upload_foto_link" class="btn btn-primary">Alterar foto</a>
				<a href="#" id="delete_foto_link" class="btn btn-link"><i class="fa fa-times fa-lg text-gray-500"></i></a>
			</div>
		</div>
		<div class="col-xs-16 col-sm-16 col-md-13 col-lg-14">
			<div class="row">
				<div class="col-xs-16 col-sm-7 col-lg-8">
                    <ul class="nav nav-tabs" role="tablist">
                        <li role="presentation" class="active">
                            <a href="#tab_dados_pessoais" aria-controls="tab_dados_pessoais" role="tab" data-toggle="tab" class="text-primary">
                                <strong class="text-primary">DADOS PESSOAIS</strong>
                            </a>
                        </li>
                    </ul>
                    <div class="tab-content">
                        <div role="tabpanel" class="tab-pane active" id="tab_dados_pessoais">
                            <div class="panel panel-default" style="border-top: none;">
                                <div class="panel-body" style="padding-top: 30px;">
                                    {{ Former::text('nome')->label('Nome')->class('form-control') }}
                                    <div class="row">
                                        <div class="col-xs-16 col-sm-5 col-md-5 col-lg-5">
                                            {{ Former::text('rg')->label('RG')->class('form-control') }}
                                        </div>
                                        <div class="col-xs-16 col-sm-5 col-md-5 col-lg-5">
                                            {{ Former::text('cpf')->label('CPF')->class('form-control') }}
                                        </div>
                                        <div class="col-xs-16 col-sm-6 col-md-6 col-lg-6">
                                            {{ Former::text('nascimento')->class('form-control datepicker')->label('Data nascimento') }}
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-xs-16 col-sm-16 col-md-16 col-lg-6">
                                            {{ Former::text('naturalidade')->class('form-control')->label('Naturalidade') }}
                                        </div>
                                        <div class="col-xs-16 col-sm-16 col-md-8 col-lg-5">
                                            {{ Former::text('local_nascimento')->class('form-control')->label('Local de nascimento') }}
                                        </div>
                                        <div class="col-xs-16 col-sm-16 col-md-8 col-lg-5">
                                            {{ Former::text('etnia')->label('Etnia')->class('form-control') }}
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-xs-4 col-sm-5 col-md-5 col-lg-4">
                                            {{ Former::select('sexo')->options(Paciente::$sexo)->label('Sexo')->class('form-control') }}
                                        </div>
                                        <div class="col-xs-12 col-sm-11 col-md-11 col-lg-12">
                                            {{ Former::text('orientacao_sexual')->class('form-control')->label('Orientação sexual') }}
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-xs-16 col-sm-16 col-md-7 col-lg-7">
                                            {{ Former::select('estado_civil')
                                                ->options(Paciente::$estado_civil)
                                                ->label('Estado civil')
                                                ->class('form-control')
                                            }}
                                        </div>
                                        <div class="col-xs-16 col-sm-16 col-md-9 col-lg-9">
                                            {{ Former::text('religiao')->label('Religião')->class('form-control') }}
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-xs-16 col-sm-7 col-md-6 col-lg-5">
                                            {{ Former::select('escolaridade')->options(Paciente::$escolaridade)->label('Escolaridade')->class('form-control') }}
                                        </div>
                                        <div class="col-xs-16 col-sm-9 col-md-10 col-lg-11">
                                            {{ Former::text('profissao')->label('Profissão')->class('form-control') }}
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-xs-16">
                                            {{ Former::text('empresa')->label('Empresa')->class('form-control') }}
                                        </div>
                                    </div>
                                    {{ Former::textarea('observacoes')->rows(4)
                                        ->label('Observações <small style="font-weight: normal;">(Uso interno)</small>')
                                        ->class('form-control') }}
                                </div>
                            </div>
                        </div>
                    </div>
				</div>

				<div class="col-xs-16 col-sm-9 col-lg-8">
                    <ul class="nav nav-tabs" role="tablist">
                        <li role="presentation" class="active">
                            <a href="#tab_contato" aria-controls="tab_contato" role="tab" data-toggle="tab" class="text-primary">
                                <strong class="text-primary">CONTATO</strong>
                            </a>
                        </li>
                    </ul>
                    <div class="tab-content">
                        <div role="tabpanel" class="tab-pane active" id="tab_contato">
                            <div class="panel panel-default" style="border-top: none;">
                                <div class="panel-body" style="padding-top: 30px;">
                                    {{ Former::textarea('endereco')->rows(3)->label('Endereço')->class('form-control') }}
                                    <div class="row">
                                        <div class="col-sm-12">
                                            {{ Former::text('cidade')->id('cidade')->class('form-control') }}
                                            {{ Former::hidden('cidade_id')->id('cidade_id')->class('form-control') }}
                                        </div>
                                        <div class="col-sm-4">
                                            {{ Former::text('cep')->label('CEP')->class('form-control') }}
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-xs-9 col-sm-9 col-md-6 col-lg-6">
                                            {{ Former::text('fone_residencial')->label('Telefone')->class('form-control') }}
                                        </div>
                                        <div class="col-xs-9 col-sm-9 col-md-5 col-lg-5">
                                            {{ Former::text('fone_recado')->label('F. Recado')->class('form-control') }}
                                        </div>
                                        <div class="col-xs-9 col-sm-9 col-md-5 col-lg-5">
                                            {{ Former::text('fone_comercial')->label('F. Comercial')->class('form-control') }}
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-xs-9 col-sm-9 col-md-6 col-lg-6">
                                            {{ Former::text('fone_celular')->label('Celular')->class('form-control') }}
                                        </div>
                                        <div class="col-xs-5 col-sm-4 col-md-3 col-lg-3">
                                            {{ Former::text('operadora_celular')->label('Operadora')->class('form-control') }}
                                        </div>
                                    </div>
                                    {{ Former::email('email')->label('E-mail')->class('form-control') }}
                                </div>
                            </div>
                        </div>
                    </div>

                    <ul class="nav nav-tabs" role="tablist">
                        <li role="presentation" class="active">
                            <a href="#tab_convenio" aria-controls="tab_convenio" role="tab" data-toggle="tab" class="text-primary">
                                <strong class="text-primary">CONVÊNIO</strong>
                            </a>
                        </li>
                    </ul>
                    <div class="tab-content">
                        <div role="tabpanel" class="tab-pane active" id="tab_convenio">
                            <div class="panel panel-default" style="border-top: none;">
                                <div class="panel-body" style="padding-top: 30px;">
                                    <div class="row">
                                        <div class="col-xs-16 col-sm-10 col-md-8 col-lg-8">
                                            {{ Former::text('carteirinha')->label('Carteirinha')->class('form-control') }}
                                        </div>
                                        <div class="col-xs-16 col-sm-6 col-md-8 col-lg-8">
                                            {{ Former::text('validadecarteirinha')->class('form-control datepicker')->label('Validade carteirinha') }}
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
				</div>
			</div>            
            <div class="text-center">
                {{ Former::actions(Former::submit('SALVAR')->class('btn btn-primary')) }}
            </div>
            @if(isset($paciente->id))
                <div class="mt-6 no-print">
                    {{ View::make('layouts.admin.update-info')->with(array('user' => $paciente))->render() }}
                </div>
            @endif
		</div>
	</div>
    {{ Former::close() }}
@stop
