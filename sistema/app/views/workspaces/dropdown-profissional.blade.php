
<div class="form-group">
    <div class="input-group">
        <div class="input-group-addon">Profissional</div>
        <select
            name="terapeuta_id"
            class="form-control {{ isset($input_size) ? $input_size : '' }}"
            data-style="btn-default"
            data-size="8"
            title="Selecionar">
            <?php
            foreach ($terapeutas as $id => $option) :
                if (
                    Auth::user()->credential == 20 && 
                    !Auth::user()->isAdmin &&
                    $id != Auth::user()->id
                ) {
                    continue;
                }
                ?>
                @if ($id == $user_id)
                    <option value="{{ $id }}" selected="selected">{{ $option }}</option>
                @else
                    <option value="{{ $id }}">{{ $option }}</option>
                @endif
            <?php endforeach;?>
        </select>
    </div>
</div>
