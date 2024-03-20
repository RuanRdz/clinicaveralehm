
<div class="panel panel-default">

	<div 
		class="panel-heading" 
		style="padding-top: 5px; padding-bottom: 5px;">
		
		<div class="row">
			
			<div class="col-xs-5">
				<div class="text-primary" style="padding: 6px 0;">
					<strong>Complexidade</strong>
				</div>
			</div>

			<div class="col-xs-11 text-right">
				<style type="text/css" media="screen">
					.field-select-complexidade .form-group { margin: 0; display: inline; }
					.field-select-complexidade .form-control { display: inline; width: auto }
				</style>
				{{ Former::framework('TwitterBootstrap3') }}
				{{ Former::vertical_open()
					->action(route('complexidadepacientesStore'))
					->secure()
					->rules(Complexidadepaciente::$rules) }}	
				{{ Former::hidden('paciente_id')->value($paciente->id) }}
					<div class="field-select-complexidade text-right">
						{{ Former::select('complexidade_id')
							->options($complexidades)
							->label('') }}
						<button type="submit" class="btn btn-default btn-sm">
							<i class="fa fa-plus fa-fw"></i> Incluir
						</button>
					</div>
				{{ Former::close() }}
			</div>

		</div>

	</div>
	
	<div class="panel-body">
		
		<div 
			class="listagem_complexidade" 
			style="max-height: 100px; margin-right: 10px; overflow-y: scroll;">

			<table class="table table-sm table-bordered table-hover valign-middle table-painel">
				<?php 
				$ct = $paciente->complexidadepacientes()->get();
				$count_ct = count($ct);
				$i = 1;
				?>
				@foreach($ct as $row)
					<tr>
						<td class="text-center" style="width: 100px;">
							{{ $row->created_at }}
						</td>
						<td>
							@if($count_ct == $i)
								<strong>{{ $row->complexidade->getFullName() }}</strong>
							@else 
								{{ $row->complexidade->getFullName() }}
							@endif
						</td>
						<td>{{ View::make('layouts.admin.update-info')->with(array('user' => $row))->render() }}</td>
						<td style="width: 70px;">
							<a 
								href="{{ route('complexidadepacientesDestroy', array('id' => $row->id)) }}"
								class="confirm-destroy"
								style="color: #909090;"><i class="fa fa-trash"></i></a>
						</td>
					</tr>
					<?php $i++;?>
				@endforeach
			</table>
		</div>

	</div>
	
	<div class="panel-footer"></div>
</div>