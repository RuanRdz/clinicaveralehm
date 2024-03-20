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
		<li class="active">Parâmetros</li>
	</ol>
@stop

@section('content')
  <div class="container">
		@if(Auth::user()->id == 1)
			<p class="clearfix">
				<a
					class="btn btn-default pull-right"
					href="{{ route($routePath.'.create') }}">
					Add Parameter
				</a>
			</p>
		@endif
    <div class="jumbotron">
      <table class="table table-striped table-hover valign-middle">
        <thead>
          <tr>
            <th style="width: 100px;">Posição</th>
            <th>Descrição</th>
						<th style="width: 20px"></th>
          </tr>
        </thead>
        <tbody>
          @foreach($data as $row)
          <tr>
						<td>
              <a href="{{ route($routePath.'.edit', ['id' => $row->id]) }}">
                {{ $row->position }}
              </a>
            </td>
            <td>{{ $row->description }}</td>
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
