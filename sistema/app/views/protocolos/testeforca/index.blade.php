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
        <li class="active">Teste de Força Muscular</li>
    </ol>
@stop

@section('content')

    <div class="row">
        <div class="col-xs-16 col-sm-16 col-md-12 col-lg-10">


            <div class="panel panel-default">
                <div class="panel-heading">
                    TESTE DE FORÇA MUSCULAR
                    <a
                        href="{{ route('testeforcaCreate') }}"
                        class="btn btn-xs btn-primary pull-right"
                    ><i class="fa fa-plus"></i></a>
                </div>
                <table class="table table-condensed">
                    @foreach ($testeForca as $key => $values)
                        <?php $rows = $values['itens']?>
                        <tr>
                            <td style="width:40px"></td>
                            <td colspan="3"><h4>{{ $values['categoria'] }}</h4></td>
                        </tr>
                        @foreach($rows as $row)
                            <tr>
                                <td>{{ $row->ordem }}</td>
                                <td>
                                    {{ link_to_route('testeforcaEdit', $row->nome, ['id' => $row->id]) }}
                                </td>
                                <td>{{ $row->descricao }}</td>
                                <td style="width:20px">
                                    <a href="{{ route('testeforcaEdit', array('id' => $row->id)) }}">
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
