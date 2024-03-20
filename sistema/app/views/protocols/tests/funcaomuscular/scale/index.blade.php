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

			<table class="table table-striped table-hover valign-middle">
        <thead>
          <tr>
            <th style="width: 40px"></th>
            <th class="text-center" style="width: 70px">Grau</th>
            <th class="text-center" style="width: 90px">Rótulo</th>
            <th>Descrição</th>
						<th style="width: 100px;">Habilitado</th>
						<th style="width: 20px"></th>
          </tr>
        </thead>
        <tbody>
          @foreach($data as $row)
          <tr>
						<td class="text-center">
							<a href="{{ route($routePath.'.edit', ['id' => $row->id]) }}">
                <i class="fa fa-pencil fa-lg"></i>
              </a>
						</td>
						<td class="text-center">{{ $row->degree }}</td>
            <td class="text-center">{{ $row->name }}</td>
            <td>{{ $row->description }}</td>
						<td>
							<i class="fa fa-{{ $row->enabled == 1 ? 'check' : 'ban' }}"></i>
						</td>
						<td class="text-center">
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
@stop
