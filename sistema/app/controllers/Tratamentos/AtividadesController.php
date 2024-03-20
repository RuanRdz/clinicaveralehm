<?php

use Anamnese as Atividade;
use Anamnesetratamento as Atividadetratamento;

class AtividadesController extends \BaseController
{
    public function __construct() {

        \User::allowedCredentials(array(10, 20));
    }

    public function index($id) {
        /*
        $t = Tratamento::findOrFail($id);

        $opcoes = array(
            'A' => Atividade::bloco('A'),
            'B' => Atividade::bloco('B'),
            'C' => Atividade::bloco('C'),
            // 'D' => Atividade::bloco('D'),
            'E' => Atividade::bloco('E'),
            'F' => Atividade::bloco('F'),
        );
        $blocos            = Atividade::$blocos;
        $opcoesAtividade   = Atividade::$opcoesAtividade;
        $dadosControle     = explode(',', $t->controle_relatorio);
        $dados             = Atividadetratamento::dados($t);
        $opcoesDificuldade = Atividadetratamento::$opcoes;
        $posicionalOpcoes  = Atividadetratamento::posicionalOpcoes($t);

        // Header
        $agenda = $t
            ->agendas()
            ->where('agendasituacao_id', '=', 2)
            ->orderBy('data_sessao')
            ->get()
            ->toArray();
        $num_sessoes = count($agenda);
        if ($num_sessoes > 0) {
            $sessao_inicial = $agenda[0]['data_sessao'];
            $sessao_final   = end($agenda);
            $sessao_final   = $sessao_final['data_sessao'];
        } else {
            $sessao_inicial = '-';
            $sessao_final   = '-';
        }

        return View::make(
            'tratamentos.atividades.index',
            compact(
                't', 'blocos', 'opcoes', 'dados', 'opcoesAtividade', 'dadosControle',
                'num_sessoes', 'sessao_inicial', 'sessao_final',
                'opcoesDificuldade', 'posicionalOpcoes'
            )
        );
        */
    }

    public function edit($id) {

        $t = Tratamento::findOrFail($id);
        $opcoes = array(
            'A' => Atividade::bloco('A'),
            'B' => Atividade::bloco('B'),
            // 'C' => Atividade::bloco('C'),
            // 'D' => Atividade::bloco('D'),
            'E' => Atividade::bloco('E'),
            'F' => Atividade::bloco('F'),
        );
        $blocos = Atividade::$blocos;

        $dados = Atividadetratamento::dados($t);

        return View::make(
            'tratamentos.atividades.edit.form',
            compact('t', 'opcoes', 'blocos', 'dados')
        );
    }

    public function update() {

        $post = Input::all();
        $t = Tratamento::findOrFail($post['tratamento_id']);

        foreach ($post as $id => $value) {
            if (is_integer($id)) {
                $at = Atividadetratamento::findOrFail($id);
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
            }
        }

        return Redirect::back()->with('success', 'Cadastro atualizado.');
        // return Redirect::route(
        //     'painel', ['id' => $t->paciente->id, 'id2' => $t->id]
        // )->with('success', 'Cadastro atualizado.');
    }
}
