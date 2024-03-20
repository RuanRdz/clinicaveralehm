
@include('prontuario.modal')

<div ng-controller="ProntuarioFormCreateController">
    <div class="row">
        <div class="col-xs-16 col-sm-16 col-md-4">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <div class="flex">
                        <div class="flex-1 font-bold text-primary">
                            Histórico
                        </div>
                        <div class="flex-1 text-right">
                            <a 
                                href="{{route('prontuarioIndex', ['paciente_id' => $paciente->id])}}"
                                class="btn btn-default"
                                target="_blank">
                                <i class="fa fa-print"></i> 
                                Visualizar Impressão
                            </a>
                        </div>
                    </div>
                </div>
                
                <div ng-controller="ProntuarioListagemPainelController">
                    <table class="table table-bordered table-hover valign-middle table-painel">
                        <tbody>
                            @foreach($prontuario as $row)
                                <?php $allowActions = $row->checkTimeLimitToUpdate();?>
                                <tr>
                                    <td class="text-center" style="width: 110px;" title="ID #{{$row->id}}">
                                        @if($allowActions)
                                            <a 
                                                href="{{ route('prontuarioEdit', array('id' => $row->id)) }}"
                                                title="Editar"
                                            >
                                                <i class="fa fa-pencil"></i> {{ $row->dataprontuario }}
                                            </a>
                                        @else 
                                            <a 
                                                href="{{ route('prontuarioShow', array('id' => $row->id)) }}"
                                                title="Visualizar"
                                                target="_blank" 
                                                data-toggle="modal" 
                                                data-target="#modal_prontuario"
                                            >
                                                <i class="fa fa-check-circle"></i> {{ $row->dataprontuario }}
                                            </a>
                                        @endif
                                    </td>
                                    <td class="text-gray-600">
                                        @if($row->createdBy)
                                            <div class="text-sm" title="CADASTROU {{ timestampToBr($row->created_at, true) }}">
                                                {{ $row->createdBy->fullName }}
                                            </div>
                                        @endif
                                        @if($row->updatedBy)
                                            <div class="text-sm" title="MODIFICOU {{ timestampToBr($row->updated_at, true) }}">
                                                {{ $row->updatedBy->fullName }}
                                            </div>
                                        @endif
                                    </td>
                                    <!-- <td class="text-center">
                                        @if($row->alta)
                                            <strong class="badge text-success">Alta</strong>
                                        @endif
                                    </td> -->
                                    <td class="text-center" style="width: 16px;">
                                        @if($allowActions)
                                            <a 
                                                href="{{ route('prontuarioDestroy', array('id' => $row->id)) }}"
                                                class="confirm-destroy" 
                                            >
                                                <i class="fa fa-trash fa-fw"></i>
                                            </a>
                                        @endif
                                    </td>
                                    <td class="text-center" style="width: 16px;">
                                        <button 
                                            ng-click="carregarHtmlEvolucao('{{ route('prontuarioHtml', array('id' => $row->id)) }}')"
                                            title="Selecionar para evolução"
                                        >
                                            <i class="fa fa-copy"></i>
                                        </button>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

            </div>
        </div>
        <div class="col-xs-16 col-sm-16 col-md-12">
            <div class="row">
                <div class="col-xs-16 col-sm-16 col-md-10">
                    <div class="panel panel-default painel-form-prontuario">
                        <div class="panel-heading">
                            <div class="text-center py-3">
                                <button 
                                    ng-show="!editando"
                                    ng-click="escrever('{{ route('prontuarioCreate', array('paciente_id' => $paciente->id, 'tratamento_id' => $tratamento->id)) }}', '{{route('textosprontuariojson')}}')"
                                    type="button"
                                    id="btn-escrever-prontuario"
                                    class="btn btn-primary" 
                                    title="Escrever" 
                                    data-url="">
                                    <i class="fa fa-pencil fa-fw"></i> Escrever
                                </button>
                                <select
                                    ng-show="editando" 
                                    id="select_template_prontuario" 
                                    class="form-control"
                                    ng-model="index_gabarito_selecionado"
                                    ng-change="aplicarGabarito()"
                                >
                                    <option 
                                        ng-repeat="(idx, row) in lista_gabaritos track by idx"
                                        value="@{{idx}}" 
                                    >
                                        @{{row.nome}}
                                    </option>
                                </select>
                            </div>
                        </div>
                        <div class="panel-body" ng-show="editando">
                            <?php 
                            $prontuario = new Prontuario;
                            $prontuario->paciente_id = $paciente->id;
                            $prontuario->tratamento_id = $tratamento->id;
                            if (empty($prontuario->dataprontuario)) {
                                $prontuario->dataprontuario = date('Y-m-d');
                            }
                            $prontuarioAction = route('prontuarioStore');
                            ?>
                            @include('prontuario.form-create', ['prontuario' => $prontuario, 'action' => $prontuarioAction])
                        </div>
                    </div>
                    <div class="well mt-4">
                        @include('pacientes.form-anamnese')
                    </div>
                </div>
                <div class="col-xs-16 col-sm-16 col-md-6">
                    <table 
                        class="table table-condensed table-striped table-hover table-painel">
                        @include('pacientes.dados-pessoais')
                    </table>
                    <div class="text-right">
                        <a
                            href="{{ route('pacientesEdit', ['id' => $paciente->id]) }}"
                            class="btn btn-default mb-1"
                            target="_blank">
                            <i class="fa fa-pencil"></i> Editar
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
