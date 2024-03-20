@extends('layouts.admin.template')

@section('head')
	@parent
	<title>Sistema</title>
@stop

@section('main-panel-heading')
	@parent
	<ol class="breadcrumb">
		<li class="active">Mensagens</li>
	</ol>
@stop

@section('content')

<div class="panel panel-default">
	<div class="panel-body">
		<div class="row">
			<div class="col-xs-16 col-sm-5 col-md-4 col-lg-4">
				<ul class="list-group inbox_user_list">
                    @foreach($usuarios as $usuario)
                        @if ($usuario->id != Auth::user()->id)
                            <?php
                            $countMessages = $usuario
                                ->load(['tarefasde' => function ($query) {
                                    return $query
                                        ->where('para_user_id', '=', Auth::user()->id)
                                        ->where('visualizado', '=', 'N');
                                }])
                                ->tarefasde
                                ->count();
                            $countMessages == 0 ? $countMessages = '' : $countMessages;
                            $active = '';
                            if (null != $para) {
                                if ($usuario->id == $para->id) {
                                    $active = 'active';
                                }
                            }
                            ?>
                            <a
                                href="{{ route('inbox', ['id' => $usuario->id]) }}"
                                class="list-group-item {{ $active }}">
                                <span class="badge">{{ $countMessages }}</span>
                                {{ $usuario->name }}
                            </a>
                        @endif
                    @endforeach
				</ul>
			</div>
			<div class="col-xs-16 col-sm-11 col-md-12 col-lg-12">
				<div class="panel panel-default">
					<div class="panel-body inbox_messages">
                        @foreach($inbox as $row)
                            @if($row->para->id != Auth::user()->id)
                                <div class="row">
                                    <div class="col-xs-14 col-sm-13 col-md-13 col-lg-13 col-xs-offset-2 col-sm-offset-3 col-md-offset-3 col-lg-offset-3">
                                        <div class="panel panel-default">
                                            <div class="panel-body inbox_message_sent">
                                                {{ nl2br($row->mensagem) }}
                                            </div>
                                            <div class="panel-footer inbox_message_footer" style="text-align: right;">
                                                <span class="text-muted">
                                                    <span title="Enviado">
                                                        {{ timestampToBr($row->created_at, true) }}
                                                    </span>
                                                    &nbsp;&nbsp;
                                                    @if ($row->visualizado == 'Y')
                                                        <span class="text-muted" title="Lido">
                                                            <i class="fa fa-eye fa-lg"></i>
                                                        </span>
                                                    @else
                                                        <span class="text-primary" title="Não lido">
                                                            <i class="fa fa-eye-slash fa-lg"></i>
                                                        </span>
                                                    @endif
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @else
                                <div class="row">
                                    <div class="col-xs-14 col-sm-13 col-md-13 col-lg-13">
                                        <div class="panel panel-{{$row->visualizado == 'Y' ? 'success' : 'primary'}}">
                                            <div class="panel-body inbox_message_received">
                                                {{ nl2br($row->mensagem) }}
                                            </div>
                                            <div class="panel-footer inbox_message_footer">
                                                    <span title="Recebido">{{ timestampToBr($row->created_at, true) }}</span>
                                                    &nbsp;&nbsp;
                                                    @if ($row->visualizado == 'Y')
                                                        <a
                                                            class="text-success"
                                                            title="Lido"
                                                            href="{{ route('inboxVisualizado', ['id' => $row->id, 'letra' => 'N']) }}">
                                                            <i class="fa fa-eye fa-fw fa-lg"></i>
                                                        </a>
                                                    @else
                                                        <a
                                                            title="Marcar como lido"
                                                            href="{{ route('inboxVisualizado', ['id' => $row->id, 'letra' => 'Y']) }}">
                                                            <i class="fa fa-eye-slash fa-fw fa-lg"></i>
                                                        </a>
                                                    @endif
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endif
                        @endforeach
					</div>
				</div>
			</div>
		</div>
	</div>
    @if(null != $para)
    	<div class="panel-footer">
    		<div class="row">
    			<div class="col-xs-16 col-sm-12 col-md-12 col-lg-12 col-sm-offset-4 col-md-offset-4 col-lg-offset-4">

    				<form class="form" action="{{ $action }}" method="post">
                        {{ Form::token() }}
                        <input type="hidden" name="de_user_id" value="{{ Auth::user()->id }}">
                        <input type="hidden" name="para_user_id" value="{{ $para->id }}">

                        <div class="input-group input-group-lg">
                            <textarea
                                class="form-control"
                                name="mensagem"
                                placeholder="Escrever..."
                                style="height: 80px;"></textarea>
                            <span class="input-group-btn" style="height: 80px;">
                                <button type="submit" class="btn btn-default" title="Enviar" style="height: 80px;">
                                    <i class="fa fa-paper-plane fa-2x text-primary"></i>
                                </button>
                            </span>
                        </div>
    				</form>

    			</div>
    		</div>
    	</div>
    @endif
</div>

@stop
