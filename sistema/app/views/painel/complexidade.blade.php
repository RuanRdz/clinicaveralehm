
<div class="panel panel-default">
	<div class="panel-heading">
        <strong class="text-primary">Grupo de Atendimento</strong>
	</div>
    <div class="panel-body" style="padding: 0;">
        <div class="m-0 p-2 bg-gray-100">
            {{ Former::framework('TwitterBootstrap3') }}
            {{ Former::vertical_open()
                ->action(route('complexidadepacientesStore'))
                ->secure()
                ->rules(Complexidadepaciente::$rules) }}	
                {{ Former::hidden('paciente_id')->value($paciente->id) }}
                <div class="flex justify-between no-wrap">
                    <div class="flex-1">
                        {{ Former::select('complexidade_id')
                            ->options($complexidades)
                            ->label('')
                            ->onGroupAddClass('m-0')
                         }}
                    </div>
                    <div class="">
                        <button type="submit" class="btn btn-default">
                            <i class="fa fa-plus"></i> Incluir
                        </button>
                    </div>
                </div>
            {{ Former::close() }}
        </div>

        <div 
            class="m-0 p-0" 
            style="max-height: 100px; overflow-y: scroll;">
            <table class="table table-condensed valign-middle table-painel text-sm">
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
                        <td style="width: 20px;">
                            <button 
                                type="button" 
                                class="btn btn-xs btn-link" 
                                data-toggle="popover" 
                                data-placement="top"
                                title="Info" 
                                data-content="{{ View::make('layouts.admin.update-info-text')->with(array('user' => $row))->render() }}">
                                <i class="fa fa-info-circle" style="color: #909090;"></i>
                            </button>
                        </td>
                        <td style="width: 20px;">
                            <a 
                                href="{{ route('complexidadepacientesDestroy', array('id' => $row->id)) }}"
                                class="confirm-destroy"
                                style="color: #909090;"><i class="fa fa-trash"></i></a>
                        </td>
                    </tr>
                    <?php $i++;?>
                @endforeach
                @if($count_ct == 0)
                    <tr>
                        <td colspan="4">
                            <div class="text-red-600 text-center">
                                <i class="fa fa-exclamation-triangle fa-lg"></i>
                                Terapeuta, defina a Complexidade inicial
                            </div>
                        </td>
                    </tr>
                @endif
            </table>
        </div>
    </div>
</div>