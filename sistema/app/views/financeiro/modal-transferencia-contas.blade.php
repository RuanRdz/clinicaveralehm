{{ Form::open(array('route' => 'financeiroTransferenciaContas', 'id' => 'form_modal_transferencia_contas', 'class' => 'form', 'role' => 'form')) }}

<div id="modal_transferencia_contas" class="modal ui-front" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            </div>
            <div class="modal-body">

                <div class="form-theme-default">
                    <div class="form-heading">
                        Transferência entre Contas
                    </div>
                    <div class="form-body">
                        <div class="form-group">
                            <div class="input-group">
                                <div class="input-group-addon bg-red-200">Conta origem: <sup>*</sup></div>
                                {{ Form::select('origem_conta_id', [''=>'']+$filtroOptions['conta'], null, ['class' => 'form-control', 'required' => true]) }}
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="input-group">
                                <div class="input-group-addon bg-green-200">Conta destino: <sup>*</sup></div>
                                {{ Form::select('destino_conta_id', [''=>'']+$filtroOptions['conta'], null, ['class' => 'form-control', 'required' => true]) }}
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-xs-8">
                                <div class="form-group">
                                    <div class="input-group">
                                        <div class="input-group-addon">Data da transferência <sup>*</sup></div>
                                        {{ Form::text('data_transferencia', null, ['class' => 'form-control datepicker', 'required' => true]) }}
                                    </div>
                                </div>
                            </div>
                            <div class="col-xs-8">
                                <div class="form-group">
                                    <div class="input-group">
                                        <div class="input-group-addon">Valor <sup>*</sup></div>
                                        {{ Form::text('valor', null, ['class' => 'form-control', 'required' => true, 'pattern' => '([0-9]{1,3}\.)?[0-9]{1,3},[0-9]{2}$']) }}
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-3">
                                <div class="form-group">
                                    <div class="input-group">
                                        <div class="input-group-addon">Tipo <sup>*</sup></div>
                                        {{ Form::select('tipo', [''=>'']+$filtroOptions['tipo'], null, ['class' => 'form-control', 'required' => true]) }}
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="form-footer">
                        <div class="col text-right">
                            @include('layouts.admin.btn-reset-filtro')
                            <button type="button" class="btn btn-default" data-dismiss="modal" aria-label="Close">Cancelar</button>
                            {{ Form::button('Transferir', ['type' => 'submit', 'class' => 'btn btn-primary']) }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
{{ Form::close() }}
