@extends('layouts.admin.template')

@section('head')
	@parent
	<title>Sistema</title>
@stop

@section('main-panel-heading')
	@parent
	<ol class="breadcrumb">
        <li>Recursos</li>
		<li>Clínica</li>
		<li><a href="{{ route('atividadesconfig') }}">Parêmetros de atividade</a></li>
        <li><a href="{{ route('atividadesconfigShow', ['bloco' => $atividade->bloco]) }}">{{ $descricao }}</a></li>
		<li class="active">Cadastro</li>
	</ol>
@stop

@section('content')
    <div class="row">
        <div class="col-xs-16 col-lg-14 col-lg-offset-1">
            <div class="row">
                <div class="col-sm-16 col-md-4">
                    @include('atividades-config.menu')
                </div>
                <div class="col-sm-16 col-md-11 col-md-offset-1">
                    <!-- form -->
                    {{ Former::framework('TwitterBootstrap3') }}
                    {{ Former::populate($atividade) }}
                    {{ Former::vertical_open()->action($action)->secure()->rules($rules) }}
                    {{ Former::hidden('bloco') }}
                    <div class="form-theme-default">
                        <div class="form-heading">{{ $blocos[$atividade->bloco] }}</div>
                        <div class="form-body">
                            {{ Former::text('nome')->label('Descrição') }}
                            <?php
                            switch ($atividade->bloco) {
                                // case 'A':
                                case 'C':
                                    echo Former::hidden('opcao')->value('simples');
                                    break;
                                case 'B':
                                case 'D':
                                case 'E':
                                case 'F':
                                    echo Former::select('opcao')
                                        ->options($opcoes)
                                        ->label('Tipo de item');
                                    break;
                            }
                            if($atividade->bloco == 'C') :
                                echo Former::select('opcao_atividade')
                                    ->options($opcoesAtividade)
                                    ->class('form-control')
                                    ->label('Atividades de auto-manutenção e autonomia');
                            endif;
                            ?>
                            <div class="row">
                                <div class="col-xs-6 col-sm-5 col-md-5 col-lg-4">
                                    {{ Former::text('ordem')->label('Sequência')->help('Número inteiro') }}
                                </div>
                            </div>
                        </div>
                        <div class="form-footer">
                            <div class="col">
                                @if ($atividade->id)
                                    <a class="confirm-destroy" href="{{ route('atividadesconfigDestroy', ['id' => $atividade->id]) }}">
                                        <i class="fa fa-trash fa-fw"></i> Excluir
                                    </a>
                                @endif
                            </div>
                            <div class="col text-right">
                                {{ Former::submit('Salvar')->class('btn btn-primary') }}
                            </div>
                        </div>
                    </div>
                    {{ Former::close() }}
                    <!-- form -->
                </div>
            </div>
        </div>
    </div>
@stop
