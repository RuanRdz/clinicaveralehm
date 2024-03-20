@extends('layouts.admin.template')

@section('head')
	@parent
	<title>Sistema</title>
@stop

@section('main-panel-heading')
	@parent
	<ol class="breadcrumb">
		<li>
			<a href="{{ route('painel', ['id' => $treatment->paciente->id, 'id2' => $treatment->id]) }}">
				{{ $treatment->paciente->nome }}
			</a>
		</li>
		<li class="active">
			<a href="{{ route($routePath.'.index', ['treatment_id' => $treatment->id]) }}">
				{{ $test->name }}
			</a>
		</li>
	</ol>
@stop

@section('content')
	<form class="form" action="{{ $action }}" method="post">
		{{ Form::token() }}
		<input type="hidden" name="treatment_id" value="{{ $treatment->id }}">

		<div class="panel panel-default">
			
			<div class="panel-heading">
				@include('protocols.tests.header-form')
			</div>

			<div class="panel-body clearfix hidden-print">
				@include('protocols.tests.form-submit')
			</div>

			<?php
			$auxGroup = '';
			$c1i = $c2i = 0;
            ?>
            <div class="table-responsive">
                <table 
                    class="table table-bordered table-striped table-hover valign-middle"
                    style="min-width: 800px;">
                    <thead>
                        <tr>
                            <th>Grupo</th>
                            <th>Atividade</th>
                            @foreach($scale as $row)
                                <th class="text-center" style="width: 130px;">
                                    {{ $row->name }}
                                </th>
                            @endforeach
                            <th class="text-muted" title="Última avaliação do tratamento atual">Anterior</th>
                            <th style="width: 20px;"></th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($paramgroups as $group)
                            <?php
                            $rowspan = count($group->params);
                            ($c1i % 2) ? $c1 = 'none;' : $c1 = '#fbfbfb;'
                            ?>
                            @foreach ($group->params as $param)
                                <?php ($c2i % 2) ? $c2 = 'none;' : $c2 = '#f3f3f3;';?>
                                <tr>
                                    @if ($group->id != $auxGroup)
                                        <td
                                            rowspan="{{ $rowspan }}"
                                            style="background: {{$c1}}">
                                            {{ $group->name }}
                                        </td>
                                        <?php $auxGroup = $group->id;?>
                                    @endif
                                    <td class="avds-input-wrap" style="background: {{$c2}}">
                                        {{ $param->name }}
                                    </td>
                                    @foreach($scale as $row)
                                        <td class="text-center avds-input-wrap" style="background: {{$c2}}">
                                            <label for="radio{{ $param->id }}{{ $row->id }}">
                                                <span>
                                                    <input
                                                        id="radio{{ $param->id }}{{ $row->id }}"
                                                        type="radio"
                                                        name="values[{{ $param->id }}]"
                                                        value="{{ $row->id }}">
                                                </span>
                                            </label>
                                        </td>
                                    @endforeach
                                    <td class="avds-input-wrap text-muted">
                                        {{ $data->getPrevious($treatment->id, $param->id) }}
                                    </td>
                                    <td class="avds-input-wrap">
                                        <button type="button" class="btn btn-sm btn-link js-uncheck-row">
                                            <i class="fa fa-times"></i>
                                        </button>
                                    </td>
                                </tr>
                                <?php $c2i++;?>
                            @endforeach
                            <?php $c1i++;?>
                        @endforeach
                    </tbody>
                </table>
            </div>
		</div>

	</form>
@stop
