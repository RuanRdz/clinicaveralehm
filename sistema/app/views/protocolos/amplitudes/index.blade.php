@extends('layouts.admin.template')

@section('head')
    @parent
    <title>Sistema</title>
@stop

@section('main-panel-heading')
    @parent
    <ol class="breadcrumb">
        <li>Clínica</li>
        <li><a href="{{ route('anamnese') }}">Relatório</a></li>
        <li class="active">Amplitude de Movimento</li>
    </ol>
@stop

@section('content')

    <div class="row">
        <div class="col-xs-16 col-sm-16 col-md-12 col-lg-10">

            <div class="panel panel-default">
                <div class="panel-heading">
                    AMPLITUDE DE MOVIMENTO
                    <a
                        href="{{ route('amplitudesCreate') }}"
                        class="btn btn-xs btn-primary pull-right"
                    ><i class="fa fa-plus"></i></a>
                </div>
                <table class="table table-condensed">
                    @foreach ($amplitude as $key => $values)
                        <?php $rows = $values['itens']?>
                        <tr>
                            <td colspan="2"><h4>{{ $values['grupo'] }}</h4></td>
                        </tr>
                        @foreach($rows as $row)
                            <tr>
                                <td>
                                    {{ link_to_route('amplitudesEdit', $row->nome, ['id' => $row->id]) }}
                                </td>
                                <td>{{ $row->parametro }}</td>
                                <td style="width:20px">
                                    <a href="{{ route('amplitudesEdit', array('id' => $row->id)) }}">
                                        <i class="fa fa-pencil fa-fw"></i>
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                    @endforeach
                </table>
            </div>

        </div>
    </div>

@stop