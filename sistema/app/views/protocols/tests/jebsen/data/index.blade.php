@extends('layouts.admin.template')

@section('head')
	@parent
	<title>Sistema</title>
@stop

@section('main-panel-heading')
	@parent
	<ol class="breadcrumb">
		<li>
			<a href="{{ route('painel', ['id' => $treatment->paciente->id, 'id2' => $treatment->id]) }}">{{ $treatment->paciente->nome }}</a>
		</li>
		<li class="active">{{ $test->name }}</li>
	</ol>
@stop

@section('content')

    <div class="row">
        <div class="col-xs-16 col-sm-16 col-md-14 col-lg-12  col-md-offset-1 col-lg-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">
                    @include('protocols.tests.header-data')
                </div>
                <div class="panel-body" style="background: #E8F7D0;">
                    @include('protocols.tests.'.$routePath.'.form-create')
                </div>
                @include('protocols.tests.'.$routePath.'.grid')
            </div>

            @if(count($testData['testdates']))
                <div class="panel panel-danger">
                    <div class="panel-heading">
                        <h4>Exclusão</h4>
                    </div>
                    <div class="panel-body">
                        <table class="table table-hover" style="font-size: 15px;">
                            <thead>
                                <tr>
                                    <th>Tratamento</th>
                                    <th colspan="2">Avaliação</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($testData['testdates'] as $treatment_id => $dates)
                                    @foreach($dates as $date)
                                        <tr>
                                            <td>#{{$treatment_id}}</td>
                                            <td>{{$date}}</td>
                                            <td style="width: 10%">
                                                @if ($treatment_id == $treatment->id)
                                                    <a
                                                        href="{{ route($routePath.'.destroy-by-date', ['treatment_id' => $treatment_id, 'date' => $date]) }}"
                                                        class="btn btn-default confirm-destroy">
                                                        <i class="fa fa-trash"></i>
                                                    </a>
                                                @else 
                                                    <button type="button" class="btn btn-default disabled">
                                                        <i class="fa fa-trash"></i>
                                                    </button>
                                                @endif
                                            </td>
                                        </tr>
                                    @endforeach
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            @endif
        </div>
    </div>

@stop
