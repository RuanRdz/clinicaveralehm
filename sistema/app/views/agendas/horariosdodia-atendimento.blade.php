
<table class="hdd-box" style="{{ $info['limite_de_faltas_css'] }}">
	<tr>
		<td colspan="2" style="background:{{ $info['bg_color'] }}">
			<div class="hdd-paciente">
				<h1 style="{{ $info['avaliacoes_pendentes_css'] }}">{{ $info['nome'] }}</h1>
			</div>
		</td>
	</tr>
	<tr>
		<td style="background:{{ $info['bg_color'] }}">
			<a 
				href="#" 
				class="btn-abrir-atalhos" 
				data-button-atalhos-id="{{$info['id']}}">
				<div class="hdd-foto">
					<div 
						class="circular-crop" 
						style="background-image: url({{ $info['foto'] }})"></div>
				</div>	
			</a>
		</td>
		<td style="background:{{ $info['bg_color'] }}; position: relative;">
			<div class="hdd-content">

				<div class="hdd-content-edit">
					<a
						class="btn btn-default btn-xs btn-agendar"
						style="margin: 0 3px 0 0;"
						href="{{ route('agendasEdit', ['id' => $info['id']]) }}"
						style="margin-top: 3px;">
						{{ $info['situacao'] }}
                    </a>
                    <label class="w-8 h-6">
                        <input type="checkbox" class="checkbox_patient_card" value="{{$info['id']}}">
                    </label>
				</div>

				<div class="hdd-content-info-container">
					<span
						class="hdd-content-sessao" 
						style="<?php echo $info['sessao'] == $info['sessoes'] ? 'color: #e53e3e' : ''?>">
						<span class="hdd-content-sessao-current">{{ $info['sessao'] }}</span>/{{ $info['sessoes'] }}
					</span>
					<?php $complx = $info['complexidade'];?>
					@if ($complx)
						<div 
							class="hdd-content-complexidade"
							style="color: {{$complx['color']}}; background: {{$complx['bg_color']}};"
							>{{$complx['grau']}}</div>
					@else
						<div class="hdd-content-complexidade">-</div>
					@endif
					<span class="hdd-content-notificacoes">
						@if ($info['notificacoes']['nao_lido'] > 0)
							<a class="btn-notificacoes-agenda text-red-600" href="{{ $info['notificacoes_route'] }}"><i class="fa fa-bell fa-lg"></i></a>
						@elseif ($info['notificacoes']['total'] > 0)
							<a class="btn-notificacoes-agenda text-red-600" href="{{ $info['notificacoes_route'] }}"><i class="fa fa-bell-o fa-lg"></i></a>
						@else
							<a class="btn-notificacoes-agenda text-gray-600" href="{{ $info['notificacoes_route'] }}"><i class="fa fa-bell-slash-o fa-lg"></i></a>
						@endif
					</span>
                    <button
                        type="button"
                        class="btn-agenda-whatsapp btn btn-link hdd-content-whatsapp"
                        data-route="{{route('agendasWhatsapp', ['id' => $info['id']])}}"
                    >
                        <i class="fa fa-whatsapp fa-lg text-success"></i>
                    </button>
					
				</div>
			</div>
			@include('agendas.horariosdodia-atalhos')
		</td>
	</tr>
</table>