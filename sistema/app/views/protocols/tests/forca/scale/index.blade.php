@extends('layouts.admin.template')

@section('head')
	@parent
	<title>Sistema</title>
@stop

@section('main-panel-heading')
	@parent
	<ol class="breadcrumb">
		<li><a href="{{ route('protocols.index') }}">Protocolos</a></li>
		<li>{{ $test->name }}</li>
		<li class="active">Escala</li>
	</ol>
@stop

@section('content')
  <div class="container">
		@if(Auth::user()->id == 1)
			<p class="clearfix">
				<a
					class="btn btn-default pull-right"
					href="{{ route($routePath.'.create') }}">
					Add Scale
				</a>
			</p>
		@endif
    <div class="jumbotron">

			<div class="row">
				<div class="col-xs-16 col-sm-8 col-md-6 col-lg-4">
					<table class="table table-striped table-hover valign-middle">
		        <thead>
		          <tr>
								<th>Peso</th>
		            <th>Sufixo</th>
		            <th style="width: 100px;">Habilitado</th>
								<th style="width: 20px;"></th>
		          </tr>
		        </thead>
		        <tbody>
		          @foreach($data as $row)
		          <tr>
								<td>
									<a href="{{ route($routePath.'.edit', ['id' => $row->id]) }}">
										{{ $row->weight }}
									</a>
								</td>
								<td>{{ $row->weightsuffix }}</td>
		            <td>
									<i class="fa fa-{{ $row->enabled == 1 ? 'check' : 'ban' }}"></i>
								</td>
								<td>
									<a
									 	href="{{ route($routePath.'.destroy', ['id' => $row->id]) }}"
										class="confirm-destroy text-muted">
										<i class="fa fa-trash"></i>
									</a>
								</td>
		          </tr>
		          @endforeach
		        </tbody>
		      </table>
				</div>
			</div>

    </div>
  </div>
@stop
