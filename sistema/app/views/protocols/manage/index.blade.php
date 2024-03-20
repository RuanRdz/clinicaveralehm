@extends('layouts.admin.template')

@section('head')
	@parent
	<title>Sistema</title>
@stop

@section('main-panel-heading')
	@parent
	<ol class="breadcrumb">
		<li class="active">Protocolos e Testes</li>
	</ol>
@stop

@section('content')
	<div class="container">

		@if(Auth::user()->id == 1)
			<p class="clearfix">
				<a class="btn btn-default pull-right" href="{{ route('tests.create') }}">
					Add Test
				</a>
				<a class="btn btn-default pull-right" href="{{ route('protocols.create') }}">
					Add Protocol
				</a>
			</p>
		@endif

		@foreach($protocols as $protocol)
			<div class="panel panel-default">
				<div class="panel-heading p-2">
					<div class="text-2xl">
						<a href="{{ route('protocols.edit', array('id' => $protocol->id)) }}">
							{{ $protocol->name }}
						</a>
					</div>
					<div>
                        {{ $protocol->description }}
                        @if ($protocol->enabled) 
                            <span class="text-green-500 pull-right">Ativo</span>
                        @else
                            <span class="text-red-500 pull-right">Inativo</span>
                        @endif 
                        <span class="text-gray-500 pull-right">({{$protocol->sort}})</span>
                    </div>

				</div>
				<!-- <div class="panel-body"> -->
					<table class="table table-striped table-hover valign-middle">
						<tbody>
							@foreach($protocol->tests as $test)
							<tr>
								<td style="width: 30%">
									<a
										href="{{ route('tests.edit', array('id' => $test->id)) }}"
										style="<?php if ($test->enabled == 0) { echo 'color: #303030'; }?>">
										{{ $test->name }}
									</a>
								</td>
								<td style="color: #606060;">{{ $test->description }}</td>
								@if(Auth::user()->id == 1)
									<td class="text-right">
										@foreach ($test->extractControllers() as $controller => $route)
                                            @if ($route != 'data')
                                                <a
                                                    href="{{ route($test->getRoutePrefix().'.'.$route.'.index') }}"
                                                    title="{{ $controller }}">{{ $route }}</a>
                                            @endif
										@endforeach
									</td>
								@endif
							</tr>
							@endforeach
						</tbody>
					</table>
				<!-- </div> -->
			</div>
		@endforeach
	</div>
@stop
