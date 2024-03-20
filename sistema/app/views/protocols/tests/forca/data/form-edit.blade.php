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
	<div class="container-fluid">

		<form class="form" action="{{ $action }}" method="post">
			{{ Form::token() }}
            <input type="hidden" name="id" value="{{ $id }}">
            <input type="hidden" name="treatment_id" value="{{ $treatment->id }}">

			<div class="panel panel-default">
				<div class="panel-heading">
					@include('protocols.tests.header-form')
				</div>
				<div class="panel-body" style="background: #D0F5F7;">
					<div class="row">
                    <div class="col-lg-2"></div>
					@foreach ($params as $param)
                        <?php
                        $values = [];
                        if (isset($scoreData[$param->id])) {
                            $values = $scoreData[$param->id];
                        } else {
                            // Para caso for acresentado algum teste novo, 
                            // que não contém chave no array $scoreData
                            $values = [
                                'id' => '',
                                'scale_id_right' => '',
                                'scale_id_left' => '',
                            ];
                        }
                        ?>
						<div class="col-xs-16 col-sm-4 col-md-4 col-lg-2">
						<div class="panel panel-default">
							<div class="panel-heading" style="min-height: 60px;">
								<strong>{{ $param->name }}</strong>
							</div>
							<div class="panel-body">
								
								<!-- RIGHT -->
								<div class="form-group">
									<label class="font-normal text-red-700">
										{{ $hands['right'] }}
									</label>
									<select
										name="values[{{$values['id']}}][scale_id_right]"
										class="form-control"
										title="Peso">
										@foreach ($scale as $id => $weight)
											<?php								
											$style = ''; 
											if (strpos($weight, '-') !== false) {
												$style = 'color: #808080 !important;'; 
											}
											if($weight == '0 kg') {
												$style = 'font-weight: bold !important;'; 
											}
											?>
											<option 
												value="{{ $id }}" 
												style="{{ $style }}" 
												{{ $id == $values['scale_id_right'] ? 'selected' : '' }}>
												{{ $weight }}
											</option>
										@endforeach
									</select>
								</div>

								<!-- LEFT -->
								<div class="form-group">
									<label class="font-normal text-red-700">
										{{ $hands['left'] }}
									</label>
									<select
										name="values[{{$values['id']}}][scale_id_left]"
										class="form-control"
										title="Peso">
										@foreach ($scale as $id => $weight)
											<?php
											$style = ''; 
											if (strpos($weight, '-') !== false) {
												$style = 'color: #808080 !important;'; 
											}
											if($weight == '0 kg') {
												$style = 'font-weight: bold !important;'; 
											}
											?>
											<option 
												value="{{ $id }}" 
												style="{{ $style }}"
												{{ $id == $values['scale_id_left'] ? 'selected' : '' }}>
												{{ $weight }}
											</option>
										@endforeach
									</select>
								</div>
							</div>
						</div>
						</div>
					@endforeach
					</div>

				</div>
				<div class="panel-footer clearfix hidden-print text-right">
                    <div class="row">
                        <div class="col-xs-16 col-sm-16 col-md-4">
                            <label style="margin-top: 10px">
                                <i class="fa fa-calendar"></i> Avaliado em: <sup>*</sup>
                            </label>
                        </div>
                        <div class="col-xs-16 col-sm-16 col-md-4">
                            <div class="form-group">
                                <input
                                    type="text"
                                    name="testdate"
                                    required="true"
                                    value="{{ $testdate }}"
                                    class="form-control datepicker">
                            </div>
                        </div>
                        <div class="col-xs-8 col-sm-8 col-md-4">
                            <button
                                type="submit"
                                class="btn btn-info">
                                SALVAR EDIÇÃO
                            </button>
                        </div>
                        <div class="col-xs-8 col-sm-8 col-md-4">
                            <a 
                                href="{{ route($routePath.'.index', ['treatment_id' => $treatment->id]) }}"
                                class="btn btn-default">
                                CANCELAR
                            </a>
                        </div>
                    </div>
				</div>
			</div>

		</form>
	</div>
@stop
