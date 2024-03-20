<?php

class RelatorioController extends BaseRelatorioController
{
    public function index($id) {

        $t = Tratamento::findOrFail($id);

        $opcoes = array(
            'A' => Anamnese::bloco('A'),
            'B' => Anamnese::bloco('B'),
            'C' => Anamnese::bloco('C'),
            // 'D' => Anamnese::bloco('D'),
            'E' => Anamnese::bloco('E'),
            'F' => Anamnese::bloco('F'),
        );
        $blocos            = Anamnese::$blocos;
        $opcoesAtividade   = Anamnese::$opcoesAtividade;
        $dadosControle     = explode(',', $t->controle_relatorio);
        $dados             = Anamnesetratamento::dados($t);
        $opcoesDificuldade = Anamnesetratamento::$opcoes;
        $posicionalOpcoes  = Anamnesetratamento::posicionalOpcoes($t);

        $tabelaforca           = Tabelaforca::listagemLayout($t);
        $testeforcatratamentos = Testeforcatratamento::listagemLayout($t);
        $amplitudetratamentos  = Amplitudetratamento::listagemLayout($t);

        // Terminologia Uniforme
        $terminologias = Terminologia::all()->toArray();
        $tuDados = $t->terminologias->lists('id');
		$tuTitles = Terminologia::where('level', '=', 2)->get()->toArray();
        $tuArray = array();
        if ($tuDados) {
            foreach ($terminologias as $values) {
                if (! in_array($values['id'], $tuDados)) { continue; }
                $tuArray[] = array(
                  'id'          => $values['id'],
                  'parent_id'   => $values['parent_id'],
                  'level'       => $values['level'],
                  'code'        => $values['code'],
                  'label'       => $values['label'],
                  'is_question' => $values['is_question'],
                );
            }
        }
        $tuTree2 = Terminologia::buildTreeHTML($tuArray, 2);
            // Tree 3
            $tuTree41 = Terminologia::buildTreeHTML($tuArray, 41);
            $tuTree42 = Terminologia::buildTreeHTML($tuArray, 42);
            $tuTree43 = Terminologia::buildTreeHTML($tuArray, 43);
        $tuTree4 = Terminologia::buildTreeHTML($tuArray, 4);

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
            'relatorio.index',
            compact(
                't', 'blocos', 'opcoes', 'dados', 'opcoesAtividade', 'dadosControle',
                'tabelaforca', 'testeforcatratamentos', 'amplitudetratamentos',
                'num_sessoes', 'sessao_inicial', 'sessao_final',
                'opcoesDificuldade', 'posicionalOpcoes',
                'tuTitles', 'tuTree2', 'tuTree41', 'tuTree42', 'tuTree43', 'tuTree4'
            )
        );
    }

    public function edit($id) {

        $t      = Tratamento::findOrFail($id);
        $opcoes = array(
            'A' => Anamnese::bloco('A'),
            'B' => Anamnese::bloco('B'),
            // 'C' => Anamnese::bloco('C'),
            // 'D' => Anamnese::bloco('D'),
            'E' => Anamnese::bloco('E'),
            'F' => Anamnese::bloco('F'),
        );
        $blocos = Anamnese::$blocos;

        $dados = Anamnesetratamento::dados($t);

        $opcoesControle = Anamnese::$opcoesControle;
        $dadosControle  = explode(',', $t->controle_relatorio);
        $dadosAnexarAnteriores = explode(',', $t->anexar_anteriores);

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
            'relatorio.edit.form',
            compact(
                't', 'opcoes', 'blocos', 'dados',
                'opcoesControle', 'dadosControle', 'dadosAnexarAnteriores',
                'num_sessoes', 'sessao_inicial', 'sessao_final'
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
            }
        }


        $t = Tratamento::find($post['tratamento_id']);
        $t->info_sessoes = $post['info_sessoes'];

        // Controle relatório
        $arr = array();
        if (isset($post['checkboxes_controle_relatorio'])) {
            foreach ($post['checkboxes_controle_relatorio'] as $option => $checked) {
                $arr[] = $option;
            }
        }
        $t->controle_relatorio = implode(',', $arr);

        // Anexar dados anteriores
        $arr = array();
        if (isset($post['checkboxes_anexar_anteriores'])) {
            foreach ($post['checkboxes_anexar_anteriores'] as $option => $checked) {
                $arr[] = $option;
            }
        }
        $t->anexar_anteriores = implode(',', $arr);


        $t->save();
        // Tratamento::find($post['tratamento_id'])->touch();


        return Redirect::route(
            'relatorio', array('id' => $post['tratamento_id'])
        )->with('success', 'Cadastro atualizado.');
    }
}
