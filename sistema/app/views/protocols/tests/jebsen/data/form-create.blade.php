
<div ng-controller="ProtocolJebsenFormController">
    <form class="form" action="{{ $action }}" method="post">
        {{ Form::token() }}
        <input type="hidden" name="treatment_id" value="{{ $treatment->id }}" required>
    
        @include('protocols.tests.form-submit')
        
        <div class="row">
            <div class="col-xs-16 col-sm-16 col-md-14 col-md-offset-1 col-lg-12 col-lg-offset-2">
                <div class="table-responsive">
                    <table class="table valign-middle" style="min-width: 600px;">
                        <thead>
                            <tr>
                                <th>Teste</th>
                                <th style="width: 40px;"></th>
                                <th style="width: 130px;">Mão Direita</th>
                                <th style="width: 40px;"></th>
                                <th style="width: 130px;">Mão Esquerda</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($params as $param)
                                <tr>
                                    <td style="font-size: 14px;">
                                        {{$param->task}}
                                    </td>
                                    <!-- RIGHT -->
                                    <td>
                                        <button
                                            type="button"
                                            class="btn btn-default btn-sm btn_time_jebsen"
                                            title="Iniciar cronômetro"
                                            ng-click="startTimer('trh_{{$param->id}}')">
                                            <i class="fa fa-play fa-lg text-muted"></i>
                                        </button>
                                    </td>
                                    <td>
                                        <input 
                                            type="text" 
                                            id="trh_{{$param->id}}"
                                            class="form-control time_jebsen" 
                                            name="time[{{$param->id}}][right_hand]"
                                            placeholder="hh:mm:ss"
                                            required>
                                    </td>
                                    <!-- LEFT -->
                                    <td>
                                        <button
                                            type="button"
                                            class="btn btn-default btn-sm btn_time_jebsen"
                                            title="Iniciar cronômetro"
                                            ng-click="startTimer('tlh_{{$param->id}}')">
                                            <i class="fa fa-play fa-lg text-muted"></i>
                                        </button>
                                    </td>
                                    <td>
                                        <input 
                                            type="text" 
                                            id="tlh_{{$param->id}}"
                                            class="form-control time_jebsen" 
                                            name="time[{{$param->id}}][left_hand]"
                                            placeholder="hh:mm:ss"
                                            required>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    
    </form>
</div>
