<?php $at = $dados[$anamnese->id]?>
<tr>
    <td>
        <div class="checkbox">
            {{ Form::hidden($at->id.'[checkbox]', 'off') }}
            <label class="checkbox">
                {{ Form::checkbox(
                    $at->id.'[checkbox]',
                    $at->checkbox,
                    $at->checkbox == 'on' ? true : false,
                    array('class' => 'checkbox')
                ) }}
                {{ $anamnese->nome }}
            </label>
        </div>
    </td>
    <td>
        @if ($anamnese->opcao == 'composta')
            <div class="form-group" style="display: block;">
                <textarea 
                    name="{{ $at->id.'[resposta]' }}" 
                    class="form-control input-sm"
                    style="width: 100%;"
                    rows="2">{{ $at->resposta }}</textarea>
            </div>
        @endif
    </td>
</tr>
