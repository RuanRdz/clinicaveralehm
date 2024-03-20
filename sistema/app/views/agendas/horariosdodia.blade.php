@extends('layouts.admin.template')

@section('head')
	@parent
	<title>Sistema</title>
@stop

@section('main-panel-heading')
	@parent

	<?php
	if (! isset($filtro['data_painel'])) {
		$filtro['data_painel'] = null;
	}
	?>

	<ol class="breadcrumb">
		<li>
			<form 
				action="{{ route('agendas') }}" 
				method="post" 
				id="formDataAgenda" 
				class="form-inline" 
				role="form">

			    <div class="form-group mr-6">
			    	<div class="input-group">
			    		<div class="input-group-addon">
			    			<strong><?php echo diaBr(date('l', strtotime($filtro['data_painel'])))?></strong>
			    		</div>
					    {{ Form::text('data_painel', timestampToBr($filtro['data_painel']),
				    		[
				    			'class' => 'form-control font-bold text-red-500 datepicker',
				    			'style' => 'width: 120px;'
				    		]
				    	)}}
				    </div>
				</div>
				@include('workspaces.dropdown-profissional', array(
					'terapeutas' => $terapeutas, 
					'user_id' => $filtro['terapeuta_id']
				))

				<!-- &nbsp;&nbsp;&nbsp;
				<div class="input-group">
					<button type="submit" class="btn btn-primary">Filtrar</button>
				</div> -->
			</form>
		</li>
        <li>
            Entradas <span style="font-size: 14px;" class="label label-default">{{$entradas}}</span>
        </li>
        <li>
            Saídas <span style="font-size: 14px;" class="label label-primary">{{$saidas}}</span>
        </li>
        <li>
            Total <span style="font-size: 14px;" class="label label-info">{{$totalAtendimentos}}</span>
        </li>
        @if ($agenda)
            <li>
                <!-- Button trigger modal modalSessionStatus -->
                <button type="button" class="btn btn-default text-red-600" data-toggle="modal" data-target="#modalSessionStatus">
                    Alterar Atendimentos
                </button>
            </li>
        @endif
    </ol>
    

@stop

@section('content')

	@if ($agenda)

		<table class="hdd">
			@foreach ($horarios as $horario)

				<?php 
				$pacientes = null;
				if (isset($agenda[$horario])):
					$pacientes = $agenda[$horario];
				endif;
				?>

				@if ($pacientes)

					<tr>
						<td 
							class="hdd-horario" 
							style="{{ $horariosDestaque[$horario] ? 'font-weight: bold; background: #fff;' : '' }}">
							{{ $horario }}
						</td>

						@foreach ($pacientes as $info)
							<td>
								@if ($info['genero'] == 'atendimento')
									@include('agendas.horariosdodia-atendimento')
								@elseif ($info['genero'] == 'bloqueio')
									@include('agendas.horariosdodia-bloqueio')									
								@elseif ($info['genero'] == 'agendamento')
									@include('agendas.horariosdodia-agendamento')	
								@endif
							</td>
						@endforeach
					</tr>

				@elseif (substr($horario, -1) == 'h')

					<tr>
						<td 
							class="hdd-horario"
							style="{{ $horariosDestaque[$horario] ? 'font-weight: bold; background: #fff;' : '' }}">
							{{ $horario }}
						</td>
						<td class="hdd-horario-vazio" colspan="7"></td>
					</tr>
				
				@endif

			@endforeach
		</table>

        <!-- Modal modalSessionStatus -->
        <div class="modal fade" id="modalSessionStatus" tabindex="-1" role="dialog" aria-labelledby="modalSessionStatusLabel">
            <div class="modal-dialog modal-sm" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <div class="modal-title text-lg" id="myModalLabel">Alterar Status de Atendimento</div>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            @foreach($situacoesAtendimento as $id => $nome)
                                <div class="radio block text-lg">
                                    <label>
                                        <input type="radio" name="radio_status_patient_card" class="radio_status_patient_card" value="{{$id}}" {{ $id == 2 ? 'checked="checked"' : '' }}>
                                        @if($id == 2)
                                            <strong class="text-red-600">{{$nome}}</strong>
                                        @else 
                                            {{$nome}}
                                        @endif
                                    </label>
                                </div>
                            @endforeach
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
                        <button type="button" id="btnSaveStatusMultiPatients" class="btn btn-primary">Salvar</button>
                    </div>
                </div>
            </div>
        </div>

	@else

        <div class="text-gray-500 text-center text-2xl my-10">
            <i class="fa fa-exclamation-circle"></i>
            @if (! Session::get('workspace_id'))
                Selecionar <u>Espaço</u>.
            @elseif(empty($filtro['terapeuta_id']))
                Selecionar <u>Profissional</u>.
            @else
                Nenhum horário agendado em {{ timestampToBr($filtro['data_inicial']) }}.
            @endif
        </div>

	@endif
@stop
