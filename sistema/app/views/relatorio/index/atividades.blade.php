<?php
$c = array();
foreach ($opcoes['C'] as $anamnese) {
    $at = $dados[$anamnese->id];
    if ($at->avaliado == 'on') {
        $c[$anamnese->opcao_atividade][] = array(
            'id' 		       => $anamnese->id,
            'nome' 	 	       => $anamnese->nome,
            'opcaoDificuldade' => $opcoesDificuldade[$at->opcao],
        );
    }
}
if(count($c) > 0) : ?>
    <div style="inline-block; break-before:always; page-break-before:always;">
        <table class="report-table">
            <thead>
                <tr>
                    <th colspan="3" class="report-table-title">{{ $blocos['C'] }}</th>
                </tr>
            </thead>

            <tbody>
                <?php
                if(isset($c['alimentacao']) || isset($c['higiene']) || isset($c['equipamentos'])) :
                    ?>
                    <td style="width:33%; vertical-align: top !important;">
                        <?php
                        foreach ($c as $key => $values) :
                            if (count($values) > 0 && ($key == 'alimentacao' || $key == 'higiene' || $key == 'equipamentos')) :
                                ?>
                                <table class="report-table">
                                    <thead>
                                        <tr>
                                            <th colspan="2">
                                                {{ $opcoesAtividade[$key] }}
                                            </th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach ($values as $k => $v) :?>
                                            <tr>
                                                <td>
                                                    <span class="no-print" style="margin: 0; padding: 0; line-height: 1; color: #999; font-family: monospace;">{{ $v['id'] }}</span>
                                                    {{ $v['nome'] }}
                                                </td>
                                                <td>
                                                    {{ $v['opcaoDificuldade'] }}
                                                </td>
                                            </tr>
                                        <?php endforeach;?>
                                    </tbody>
                                </table>
                                <?php
                            endif;
                        endforeach;
                        ?>
                    </td>
                    <?php
                endif;

                if(isset($c['vestuario']) || isset($c['manipulacao'])) :
                    ?>
                    <td style="width:33%; vertical-align: top !important;">
                        <?php
                        foreach ($c as $key => $values) :
                            if (count($values) > 0 && ($key == 'vestuario' || $key == 'manipulacao')) :
                                ?>
                                <table class="report-table">
                                    <thead>
                                        <tr>
                                            <th colspan="2">
                                                {{ $opcoesAtividade[$key] }}
                                            </th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach ($values as $k => $v) :?>
                                            <tr>
                                                <td>
                                                    <span class="no-print" style="margin: 0; padding: 0; line-height: 1; color: #999; font-family: monospace;">{{ $v['id'] }}</span>
                                                    {{ $v['nome'] }}
                                                </td>
                                                <td>
                                                    {{ $v['opcaoDificuldade'] }}
                                                </td>
                                            </tr>
                                        <?php endforeach;?>
                                    </tbody>
                                </table>
                                <?php
                            endif;
                        endforeach;
                        ?>
                    </td>
                    <?php
                endif;

                if(isset($c['comunicacao']) || isset($c['tarefas']) || isset($c['outros'])) :
                    ?>
                    <td style="width:33%; vertical-align: top !important;">
                        <?php
                        foreach ($c as $key => $values) :
                            if (count($values) > 0 && ($key == 'comunicacao' || $key == 'tarefas' || $key == 'outros')) :
                            ?>
                            <table class="report-table">
                                <thead>
                                    <tr>
                                        <th colspan="2">
                                            {{ $opcoesAtividade[$key] }}
                                        </th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($values as $k => $v) :?>
                                        <tr>
                                            <td>
                                                <span class="no-print" style="margin: 0; padding: 0; line-height: 1; color: #999; font-family: monospace;">{{ $v['id'] }}</span>
                                                {{ $v['nome'] }}
                                            </td>
                                            <td>
                                                {{ $v['opcaoDificuldade'] }}
                                            </td>
                                        </tr>
                                    <?php endforeach;?>
                                </tbody>
                            </table>
                            <?php
                            endif;
                        endforeach;
                        ?>
                    </td>
                    <?php
                endif;
                ?>
            </tbody>


            <tfoot>
                <tr>
                    <th colspan="3" class="text-center">POSICIONAL</th>
                </tr>
                <tr>
                    <td colspan="3" style="padding-left: 15% !important; padding-right: 15% !important;">
                        <table class="report-inner-table">
                            <thead>
                                <tr>
                                    <th>Início Tratamento</th>
                                    <th style="width: 15%;" class="text-center">Atividades Avaliadas</th>
                                    @foreach($opcoesDificuldade as $key => $label)
                                        <?php if ($key == 0) { continue; }?>
                                        <th style="width: 20%;" class="text-center">{{ $label }}</th>
                                    @endforeach
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($posicionalOpcoes as $id => $dados)
                                    <tr>
                                        <td>{{ $dados['data'] }}</td>
                                        <td class="text-center">{{ $dados['total'] }}</td>
                                        @foreach($dados['posicional'] as $item => $posicao)
                                            <?php if ($item == 0) { continue; }?>
                                            <td class="text-center" style="font-weight: bold !important;">{{ $posicao }}%</td>
                                        @endforeach
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </td>
                </tr>
            </tfoot>

        </table>
    </div>

<?php endif;?>
