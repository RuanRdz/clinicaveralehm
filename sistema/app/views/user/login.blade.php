
<?php $s = Sistema::parametros()?>

@extends('layouts.site.template')

@section('head')
	@parent
	<title>{{ $s['empresa'] }}</title>
@stop

@section('content')

	<div class="formLogin">

		{{ Former::framework('TwitterBootstrap3') }}
		{{
			Former::vertical_open()
			->action(route('entrar'))
            ->secure()
            ->autocomplete('off')
			->rules([
				'email' => 'required|email',
				'password' => 'required',
			])
		}}

        <div class="row mt-4 lg:mt-20">
            <div class="col-xs-16 col-md-4 col-lg-4 col-lg-offset-2">
                <div class="text-center my-8">
                    <img src="{{URL::asset('img/vera-lehm-logotype.png')}}" class="inline">
                </div>
            </div>
            <div class="col-xs-16 col-md-12 col-lg-6">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        Login
                    </div>
                    <div class="panel-body">
                        {{
                        Former::email('email')
                            ->label('E-mail')
                            ->inline()
                            ->stacked()
                            ->autocomplete('off')
                            ->class('form-control')
                        }}
                        <div class="row">
                            <div class="col-xs-10 col-md-7">
                                {{
                                Former::password('password')
                                    ->label('Senha')
                                    ->autocomplete('off')
                                    ->class('form-control')
                                }}
                            </div>
                        </div>
                    </div>
        
                    <div class="panel-footer">
                        {{ Former::submit('ENTRAR')->class('btn btn-primary') }}
                    </div>
                </div>
            </div>
        </div>

        <?php
        /*
        <div class="row">
            <div class="col-xs-16 col-sm-15 col-md-15 text-center">
                <h1 class="nome_empresa">
                    {{ $s['empresa'] }}
                </h1>
                <p>{{ $s['telefone'] }}</p>
            </div>
            <div class="col-xs-16 col-sm-1 col-md-1 text-right">
                <a href="{{ $s['facebook'] }}"><i class="fa fa-facebook-square fa-2x"></i></a>
            </div>
        </div>
        */
        ?>

		{{ Former::close() }}

	</div>

@stop
