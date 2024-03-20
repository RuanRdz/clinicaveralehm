<div class="col-xs-16 col-sm-16 col-md-7 col-lg-7">
    <div class="panel panel-default">
        <div class="panel-heading">INFORMAÇÕES E PROTOCOLOS</div>
        <div class="panel-body">
            <table class="table table-condensed table-bordered">
                <thead>
                    <th class="text-center" colspan="2" style="vertical-align: middle;">Itens</th>
                    <th class="text-center" style="vertical-align: middle;">Anexar anteriores</th>
                </thead>
                <tbody>
                    @foreach($opcoesControle as $option => $label)
                        <?php
                        in_array($option, $dadosControle)
                        ? $checked = 'checked="checked"'
                        : $checked = '';

                        in_array($option, $dadosAnexarAnteriores)
                        ? $checkedAnteriores = 'checked="checked"'
                        : $checkedAnteriores = '';
                        ?>
                        <tr>
                            <td class="text-center">
                                <div class="checkbox">
                                    <label class="checkbox">
                                        <input
                                        class="checkbox"
                                        type="checkbox"
                                        name="checkboxes_controle_relatorio[{{ $option }}]"
                                        value="{{ $option }}"
                                        {{ $checked }}>
                                    </label>
                                </div>
                            </td>
                            <td>
                                {{ $label }}
                            </td>
                            <td class="text-center">
                                <?php
                                switch ($option) {
                                    case 'C':
                                    case 'TF':
                                    case 'TFM':
                                    case 'AM':
                                    ?>
                                    <input
                                    class="checkbox"
                                    type="checkbox"
                                    name="checkboxes_anexar_anteriores[{{ $option }}]"
                                    value="{{ $option }}"
                                    {{ $checkedAnteriores }}>
                                    <?php
                                    break;
                                }
                                ?>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
