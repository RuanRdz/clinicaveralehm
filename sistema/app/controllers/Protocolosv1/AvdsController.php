<?php

class AvdsController extends BaseRelatorioController
{
    public function edit($id) {

        $t      = Tratamento::findOrFail($id);
        $avds   = Anamnese::bloco('C');
        $blocos = Anamnese::$blocos;
        $dados  = Anamnesetratamento::dados($t);
        $opcoesAtividade   = Anamnese::$opcoesAtividade;
        $opcoesDificuldade = Anamnesetratamento::$opcoes;

        return View::make(
            'protocolos.avds.form',
            compact(
                't', 'avds', 'blocos', 'dados',
                'opcoesAtividade', 'opcoesDificuldade'
            )
        );
    }


    public function update() {

        $post = Input::all();

        foreach ($post as $id => $value) {
            if (is_integer($id)) {
                $at = Anamnesetratamento::findOrFail($id);
                if (isset($value['checkbox'])) {
                    $at->checkbox = $value['checkbox'];
                }
                if (isset($value['avaliado'])) {
                    $at->avaliado = $value['avaliado'];
                }
                if (isset($value['opcao'])) {
                    $at->opcao = $value['opcao'];
                }
                if (isset($value['resposta'])) {
                    $at->resposta = $value['resposta'];
                }
                $at->save();
                $at->tratamento->setFezAvaliacao();
            }
        }

        return Redirect::route(
            'avdsEdit', array('id' => $post['tratamento_id'])
        )->with('success', 'Cadastro atualizado.');
    }
}
