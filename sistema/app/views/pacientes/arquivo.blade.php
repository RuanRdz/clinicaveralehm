@extends('layouts.admin.template')

@section('head')
	@parent
	<title>Sistema</title>
@stop

@section('main-panel-heading')
	@parent
	<ol class="breadcrumb">
		<li>Pacientes</li>
		<li><a href="{{ route('painel', ['id' => $paciente->id]) }}">{{ $paciente->nome }}</a></li>
		<li class="active">Arquivo</li>
	</ol>
@stop

@section('content')

	<div class="row">
		<div class="col-xs-16 col-sm-16 col-md-5 col-lg-4">
			<div class="well well-sm">
				{{ Former::framework('TwitterBootstrap3') }}
				{{
				Former::vertical_open_for_files()
				->action(route('pacientesArquivoStore'))
				->secure()
				->rules([
					'arquivo' => 'required|max:20000'
				]);
				}}
				{{ Former::hidden('id')->value($paciente->id) }}
				{{ Former::file('arquivo')->label('Enviar Arquivo') }}
				<button class="btn btn-primary btn-sm" type="submit">
					<i class="fa fa-cloud-upload"></i> Enviar
				</button>
				{{ Former::close() }}
			</div>
		</div>

		<div class="col-xs-16 col-sm-16 col-md-11 col-lg-12">
            <div class="bg-white shadow-md">
                <table class="table table-bordered">
                    @foreach($arquivos as $array)
                        <?php
                        $filename = $array['filename'];
                        $type = $array['type'];
                        $modified = $array['modified'];
                        ?>
                        <tr>
                            <td>
                                {{
                                link_to_route(
                                    'PacientesArquivoDownload',
                                    $filename,
                                    [
                                        'id' => $paciente->id,
                                        'config_path' => $array['config_path'],
                                        'filename' => $filename,
                                    ]
                                );
                                }}
                            </td>
                            <td style="width:130px">
                                {{ $modified }}
                            </td>
                            <td class="text-center" style="width:30px">
                                <a
                                    class="btn btn-danger btn-xs confirm-destroy"
                                    href="{{
    									route(
                                            'PacientesArquivoDelete', [
                                                'id' => $paciente->id,
                                                'config_path' => $array['config_path'],
                                        		'filename' => $filename,
                                            ]
                                        )
                                    }}"
                                >
                                    <i class="fa fa-trash"></i>
                                </a>
                            </td>
                        </tr>
                    @endforeach
                </table>
            </div>
		</div>

	</div>
@stop