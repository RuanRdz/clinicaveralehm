<div class="modal" tabindex="-1" role="dialog" id="js-modal-funcamuscular">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">{{ $test->name }}</h4>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <input 
                        type="text" 
                        name="filter_param"
                        value="{{Session::get('filter_param')}}"
                        id="js-list-funcamuscular-filter"
                        class="form-control"
                        style="border-color: green"
                        placeholder="Filtrar" 
                    >
                </div>
                <table class="table table-bordered table-hover" id="js-list-funcamuscular-param_id">
                    <thead>
                        <th></th>
                        <th class="text-lg text-red-600 py-3">Movimento</th>
                        <th class="text-lg text-red-600 py-3">Grupo Muscular</th>
                    </thead>
                    @foreach($paramgroups as $group)
                        <?php 
                        $params = $group->params()->orderBy('sort')->get();
                        $expandGroup = true;
                        $countParams = count($params);
                        ?>
                        <tbody style="border-top: 2px solid #000 !important; border-bottom: 2px solid #000 !important;">
                            @foreach($params as $param)
                                <tr id="{{$param->id}}" style="cursor: pointer !important;">
                                    @if($expandGroup)
                                        <td rowspan="{{$countParams}}">{{$group->name}}</td>
                                    @endif
                                    <td class="label-moviment">{{$param->moviment}}</td>
                                    <td class="label-muscle" style="font-weight: bold;">{{$param->muscle}}</td>
                                </tr>
                                <?php $expandGroup = false;?>
                            @endforeach
                        </tbody>
                    @endforeach
                </table>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->