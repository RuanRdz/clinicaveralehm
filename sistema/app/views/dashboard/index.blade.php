@extends('layouts.admin.template')

@section('head')
	@parent
	<title>Sistema</title>
@stop

@section('main-panel-heading')
	@parent
	<ol class="breadcrumb">
		<li class="active">Página inicial</li>
	</ol>
@stop

@section('content')
    <div class="container">
        <div class="flex justify-around content-center items-center flex-wrap text-xl no-underline">
            <a class="w-full md:w-1/3 lg:w-1/4 xl:w-1/4 no-underline" href="{{route('agendas')}}">
                <div class="m-2 py-10 text-red-600 bg-red-100 hover:bg-red-200 text-center rounded-lg shadow-lg">
                    <i class="opacity-25 fa fa-2x fa-calendar fa-fw"></i> 
                    <div class="no-underline">Horários do dia</div>
                </div>
            </a>
            @if (User::allowedCredentials([10], true))
                <a class="w-full md:w-1/3 lg:w-1/4 xl:w-1/4 no-underline" href="{{ route('financeiroMovimentacao') }}">
                    <div class="m-2 py-10 text-green-600 bg-green-100 hover:bg-green-200 text-center rounded-lg shadow-lg">
                        <i class="opacity-25 fa fa-2x fa-dollar fa-fw"></i> 
                        <div class="no-underline">Movimentação</div>
                    </div>
                </a>
            @endif
            @if (User::allowedCredentials([10, 30], true))
                <a class="w-full md:w-1/3 lg:w-1/4 xl:w-1/4 no-underline" href="{{ route('financeiroReceber') }}">
                    <div class="m-2 py-10 text-blue-600 bg-blue-100 hover:bg-blue-200 text-center rounded-lg shadow-lg">
                        <i class="opacity-25 fa fa-2x fa-dollar fa-fw"></i> 
                        <div class="no-underline">Faturamento Pacientes</div>
                    </div>
                </a>
            @endif
            @if (User::allowedCredentials([10], true))
                <a class="w-full md:w-1/3 lg:w-1/4 xl:w-1/4 no-underline" href="{{ route('financeiroProducao') }}">
                    <div class="m-2 py-10 text-purple-600 bg-purple-100 hover:bg-purple-200 text-center rounded-lg shadow-lg">
                        <i class="opacity-25 fa fa-2x fa-dollar fa-fw"></i> 
                        <div class="no-underline">Produção Profissionais</div>
                    </div>
                </a>
            @endif
            @if (User::allowedCredentials([10], true))
                <div class="mt-12">
                    <a href="{{ route('results') }}" class="no-underline">
                        <div class="py-3 px-3 md:px-10 text-grey-600 bg-grey-100 hover:bg-grey-200 text-center rounded-lg shadow-lg">
                            <i class="fa fa-lg fa-flask fa-fw"></i>
                            Resultados
                        </div>
                    </a>
                </div>
            @endif
        </div>
    </div>
@stop
