

<div class="text-2xl">{{$dados->tratamento->paciente->nome}}</div>

<div class="my-6 p-6 bg-gray-200">

    <form 
        id="form-paciente-update-celular"
        action="{{route('pacientesUpdateCelular', ['id' => $dados->tratamento->paciente_id])}}"
        method="POST"
    >
        {{Form::token()}}
        <div class="row">
            <div class="col-sm-1 pt-2 font-bold">
                Celular
            </div>
            <div class="col-sm-3">
                <input id="input-fone-whatsapp" type="text" class="form-control" name="fone_celular" value="{{$fone}}" required>
            </div>
            <div class="col-sm-12">
                <button type="submit" class="btn btn-default">Salvar</button>
            </div>
        </div>
        <div class="mt-2 text-gray-600">
            Acrescentar <span class="font-bold text-red-600">55</span> no início. Remover espaços, letras e caracteres, manter <span class="font-bold">apenas números</span>.
        </div>
    </form>
</div>

<div class="whatsapp_links">
    @foreach($texts as $item)
        <a href="{{$url.$fone.$item['text']}}" target="_blank" class="btn btn-default" data-text="{{$item['text']}}"><i class="fa fa-whatsapp"></i> {{$item['label']}}</a>
    @endforeach
</div>
