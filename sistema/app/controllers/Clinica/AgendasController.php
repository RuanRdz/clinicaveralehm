<?php

class AgendasController extends \BaseController {

    /**
     * Horários do Dia
     */
    public function index()
    {
        $filtro = filtro();
        $agenda = Agenda::horariosDoDia($filtro);
        
        $es = Agenda::contagemEntradasSaidas($agenda);
        $entradas = $es['entradas'];
        $saidas = $es['saidas'];
        $totalAtendimentos = $es['total'];

        $horarios = horarios();
        unset($horarios['']);

        $horariosDestaque = horariosDestaque();

        Session::get('workspace_id')
            ? $terapeutas = array('' => '') + Workspace::terapeutas(Session::get('workspace_id'))->lists('fullName', 'id')
            : $terapeutas = array('' => '');

        $situacoesAtendimento = Cache::remember('users', 1440, function() { // 1440 minutes (24h)
            return Agendasituacao::lists('nome', 'id');
        });

        $dados = compact(
            'filtro', 'agenda', 'terapeutas', 
            'horarios', 'horariosDestaque',
            'entradas', 'saidas', 'totalAtendimentos',
            'situacoesAtendimento'
        );

        return View::make('agendas.horariosdodia', $dados);
    }

    public function controle()
    {
        User::allowedCredentials(array(10, 20, 30));
        $filtro = filtro();
        $agenda = Agenda::controle($filtro);
        Session::get('workspace_id')
            ? $terapeutas = array('' => '') + Workspace::terapeutas(Session::get('workspace_id'))->lists('fullName', 'id')
            : $terapeutas = array('' => '');
        $situacoes = array('' => '') + Agendasituacao::lists('nome_sumario', 'id');
        $medicos = array('' => '') + Medico::orderBy('nome', 'asc')->lists('nome', 'id');
        $convenios = array('' => '') + Convenio::orderBy('nome', 'asc')->lists('nome', 'id');
        $tratamentotipos = array('' => '') + Tratamentotipo::orderby('sequencia')->lists('nome', 'id');
        $sessoes   = array(
            ''          => '',
            'primeira'  => 'Primeira',
            'penultima' => 'Penúltima',
            'ultima'    => 'Última',
        );
        
        switch ($filtro['genero']) {
            case 'atendimento':
                $view = 'agendas.controle';
            break;
            case 'bloqueio':
                $view = 'agendas.controle-bloqueados';
            break;
            case 'agendamento':
                $view = 'agendas.controle-agendamentos';
            break;
        }

        $listaPacientes = [];
        $listaMedicos = $listaMedicosNomes = $listaMedicosContagem = [];
        $listaConvenios = $listaConveniosNomes = $listaConveniosContagem = $listaConveniosValores = [];
        $listaSessoes = $graficoSessoes = [];

        if ($filtro['genero'] == 'atendimento') {

            foreach (Agendasituacao::lists('nome_sumario', 'id') as $id => $label) {
                $sessoesSituacao[$id] = [
                    'label' => $label,
                    'contagem' => 0
                ];
            }

            foreach ($agenda as $item) {
                if (!$item->tratamento) {
                    continue;
                }
                // Pacientes
                if ($item->tratamento->paciente) {
                    $listaPacientes[$item->tratamento->paciente_id] = $item->tratamento->paciente->nome;
                }
                // Médicos
                if ($item->tratamento->medico) {
                    $id = $item->tratamento->medico_id;
                    $listaMedicosNomes[$id] = $item->tratamento->medico->nome;
                    if ($item->agendasituacao_id == 2) { // Só os atendidos/concluídos
                        if (!isset($listaMedicosContagem[$id])) {
                            $listaMedicosContagem[$id] = 0;
                        }
                        $listaMedicosContagem[$id] += 1; 
                    }
                }
                // Convênios
                if ($item->tratamento->convenio) {
                    $id = $item->tratamento->convenio_id;
                    $listaConveniosNomes[$id] = $item->tratamento->convenio->nome;
                    if ($item->agendasituacao_id == 2) { // Só os atendidos/concluídos
                        $listaConveniosValores[$id] = $item->tratamento->getOriginal('valor_sessao');
                        if (!isset($listaConveniosContagem[$id])) {
                            $listaConveniosContagem[$id] = 0;
                        }
                        $listaConveniosContagem[$id] += 1; 
                    }
                }
                // Sessões
                if (isset($sessoesSituacao[$item->agendasituacao_id])) {
                    $sessoesSituacao[$item->agendasituacao_id]['contagem']++;
                }
            }

            $contagemSessoes = [];
            foreach ($sessoesSituacao as $key => $value) {
                $contagemSessoes[$value['label']] = $value['contagem'];
            }
            arsort($contagemSessoes);
            foreach ($contagemSessoes as $label => $serie) {
                $listaSessoes[] = [
                    'situacao' => $label,
                    'contagem' => $serie
                ];
                $graficoSessoes['labels'][] = $label;
                $graficoSessoes['series'][] = $serie;
            }
            $sumSeries = array_sum($graficoSessoes['series']);
            foreach ($graficoSessoes['series'] as $key => $value) {
                $graficoSessoes['series'][$key] = ($sumSeries > 0) ? number_format(($value/$sumSeries)*100, 2) : 0;
            }
            $graficoSessoes = json_encode($graficoSessoes);

            // Lista médicos
            arsort($listaMedicosContagem);
            $listaMedicos = ['listagem' => [], 'series' => [], 'labels' => []];
            // $listaMedicos['labels'][] = $listaMedicosNomes[$id];
            foreach ($listaMedicosContagem as $id => $value) {
                $listaMedicos['listagem'][$id] = [
                    'nome' => $listaMedicosNomes[$id],
                    'sessoes' => $value,
                ];
                $listaMedicos['series'][] = $value;
                $listaMedicos['labels'][] = $listaMedicosNomes[$id];
            }
            $sumSeries = array_sum($listaMedicos['series']);
            foreach ($listaMedicos['series'] as $key => $value) {
                $listaMedicos['series'][$key] = ($sumSeries > 0) ? number_format(($value/$sumSeries)*100, 2) : 0;
            }
            $listaMedicos['grafico'] = json_encode([
                'series' => $listaMedicos['series'],
                'labels' => $listaMedicos['labels']
            ]);
            unset($listaMedicos['series']);
            unset($listaMedicos['labels']);

            // Lista convênios
            arsort($listaConveniosContagem);
            $listaConvenios = ['listagem' => [], 'series' => [], 'labels' => []];
            foreach ($listaConveniosContagem as $id => $value) {
                $listaConvenios['listagem'][$id] = [
                    'nome' => $listaConveniosNomes[$id],
                    'sessoes' => $value,
                ];
                $listaConvenios['series'][] = $value;
                $listaConvenios['labels'][] = $listaConveniosNomes[$id];
            }
            $sumSeries = array_sum($listaConvenios['series']);
            foreach ($listaConvenios['series'] as $key => $value) {
                $listaConvenios['series'][$key] = ($sumSeries > 0) ? number_format(($value/$sumSeries)*100, 2) : 0;
            }
            $listaConvenios['grafico'] = json_encode([
                'series' => $listaConvenios['series'],
                'labels' => $listaConvenios['labels']
            ]);
            unset($listaConvenios['series']);
            unset($listaConvenios['labels']);

            $totalConvenios = 0;
            foreach ($listaConvenios['listagem'] as $id => $item) {
                $valor = $listaConveniosValores[$id];
                $subtotal = $valor * $item['sessoes'];
                $totalConvenios += $subtotal; 
                $listaConvenios['listagem'][$id]['subtotal'] = number_format($subtotal, 2, ',', '.');
            }
            $listaConvenios['valor_total'] = number_format($totalConvenios, 2, ',', '.');

            // Lista pacientes
            sort($listaPacientes);
        }

        $dados = compact(
            'filtro', 'agenda', 'terapeutas', 'situacoes', 'sessoes', 'medicos', 'tratamentotipos', 'convenios',
            'listaPacientes', 'listaMedicos', 'listaConvenios', 'listaSessoes', 'graficoSessoes'
        );

        return View::make($view, $dados);
    }

    /**
     * Show the form for editing the specified agenda.
     *
     * @param  int  $id
     * @return Response
     */
    public function edit($id)
    {
        $agenda = Agenda::with(
                'agendasituacao', 
                'tratamento', 
                'tratamento.agendas', 
                'tratamento.paciente', 
                'tratamento.paciente.complexidadepacientes',
                'tratamento.paciente.complexidadepacientes.complexidade'
        )->findOrFail($id);

        $checkUltimaSessaoAtendimentos = $agenda->checkUltimaSessaoAtendimentos();
        
        $terapeutas = array('' => '');
        $terapeutasList = array();
        if (Session::get('workspace_id')) {
            $terapeutasList = Workspace::terapeutas(Session::get('workspace_id'))->lists('fullName', 'id');
        }
        $terapeutas += $terapeutasList;
        $complexidades = Complexidade::selectBox();
        $complexidadeAtual = $agenda->tratamento->paciente->complexidadeAtual();

        $rules = Agenda::$rules;
        return View::make('agendas.edit', compact(
            'agenda', 'checkUltimaSessaoAtendimentos', 
            'terapeutas', 'rules', 
            'complexidades', 'complexidadeAtual'
        ));
    }

    public function edicaoRapidaSessoes($tratamento_id)
    {
        $tratamento = Tratamento::with('paciente')
            ->findOrFail($tratamento_id);

        $agenda = Agenda::with('agendasituacao')
            ->where('agendas.tratamento_id', '=', $tratamento->id)
            ->orderBy('agendas.sessao')
            ->get();

        return View::make('agendas.edicao-rapida-sessoes', compact(
            'tratamento',
            'agenda'
        ));
    }

    public function updateEdicaoRapidaSessoes($tratamento_id)
    {
        $data = Input::all();
        $keys = array_keys($data['data_sessao']);
        $sessoes = [];
        $i = 0;
        foreach ($keys as $id) {
            $agenda = Agenda::find($id);
            if ($agenda) {
                // Define dados
                $values = [
                    'data_sessao' => $data['data_sessao'][$id],
                    'inicio' => $data['inicio'][$id],
                    'fim' => $data['fim'][$id],
                    'agendasituacao_id' => $data['agendasituacao_id'][$id]
                ];
                // Verifica se houve algum update
                if (
                    $agenda->data_sessao != $values['data_sessao'] ||
                    $agenda->inicio != $values['inicio'] ||
                    $agenda->fim != $values['fim'] ||
                    $agenda->agendasituacao_id != $values['agendasituacao_id']
                ) {
                    // Executa o update
                    $i++;
                    $agenda->data_sessao = $values['data_sessao'];
                    $agenda->inicio = $values['inicio'];
                    $agenda->fim = $values['fim'];
                    $agenda->agendasituacao_id = $values['agendasituacao_id'];
                    if ($agenda->save()) {
                        Agendalog::registrar($agenda, $values);
                    }
                }
            }
        }
        Session::flash('success', "Editou $i sessões.");
        return 1;
    }

    public function store()
    {
        $num_sessoes = Input::get('num_sessoes');
        $tratamento = Tratamento::findOrFail(Input::get('tratamento_id'));
        $sessoes_disponiveis = $tratamento->getNumSessoesDisponiveis();

        $validator = Validator::make(['num_sessoes' => $num_sessoes], [
            'num_sessoes' => 'required|integer|min:1'
        ]);
        if ($validator->fails()){
            // Session::flash('fail', 'Erro de validação ao salvar Agenda.');
            return Redirect::back()->withErrors($validator)->withInput();
        }

        if ($num_sessoes > $sessoes_disponiveis) {
            return Redirect::back()->with('fail', 'O número de sessões informado excede o total disponível');
        }

        $proxima = (int) $tratamento->sessoes;
        $ultima = $proxima + ($num_sessoes - 1);
        $unidades = range($proxima, $ultima);
        foreach ($unidades as $sessao) {
            Agenda::adicionarData($tratamento, $sessao);
        }
        $tratamento->sessoes = $tratamento->agendas()->count();
        $tratamento->save();

        $this->reordenaTodasAsSessoes($tratamento);

        return Redirect::back()->with('success', 'Sessões adicionadas');
    }

    /**
     * Update the specified agenda in storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function update($id)
    {
        $agenda    = Agenda::with('tratamento')->findOrFail($id);
        $data      = Input::all();
        $validator = Validator::make($data, Agenda::$rules);

        if ($validator->fails()){
            // dd($validator->errors());
            // TODO rever isso, redirect via ajax
            // return Redirect::back()->withErrors($validator)->withInput();
            Session::flash('fail', 'Erro de validação ao salvar Agenda.');
        }

        if (isset($data['terapeuta_id'])) {
            if (empty($data['terapeuta_id'])) {
                $msg  = 'Para editar a Agenda é necessário selecionar um <u>Terapeuta</u>.<br />';
                $msg .= 'Verificar a <u>Área de Trabalho</u> selecionada e acesso do Usuário';
                Session::flash('fail', $msg);
            } else {
                if (Agenda::horarioBloqueado($data)) {
                    $msg  = 'Há um bloqueio no horário <b>'.$data['inicio'].'</b> ';
                    $msg .= 'do dia <b>'.$data['data_sessao'].'</b>. Selecione um horário não bloqueado.';
                    Session::flash('fail', $msg);
                } else {
                    // Log alteração
                    Agendalog::registrar($agenda, $data);
                    $agenda->update($data);
                    if ($agenda->tratamento->terapeuta_id != $data['terapeuta_id']) {
                        $agenda->tratamento->update(array('terapeuta_id' => $data['terapeuta_id']));
                    }
                    if (trim($data['complexidade_id'])) {
                        // Alterar a complexidade do paciente
                        $complexidade = new Complexidadepaciente;
                        $complexidade->complexidade_id = $data['complexidade_id'];
                        $complexidade->paciente_id = $agenda->tratamento->paciente_id;
                        $complexidade->save();
                    }
                    if (isset($data['concluir_tratamento'])) {
                        $agenda->tratamento->update(array('tratamentosituacao_id' => 2));
                        # Faz o lançamento automático do saldo se estiver ativado
                        // if (isset($agenda->tratamento->convenio)) {
                        //     if (isset($agenda->tratamento->convenio->conveniotipo)) {
                        //         if ($agenda->tratamento->convenio->conveniotipo->lancamento_automatico) {
                        //             Financeiro::lancamentoAutomatico($tratamento);
                        //         }
                        //     }
                        // }
                    }
                }
            }
        }
        return 1;
    }

    public function destroy($id) 
    {
        User::allowedCredentials(array(10, 30));
        $agenda = Agenda::findOrFail($id);
        if ($agenda->agendasituacao_id != 1) {
            echo htmlentities('Apenas sessões com situação "Aberto" podem ser removidas', ENT_QUOTES, "UTF-8");
            die;
        }
        $tratamento_id = $agenda->tratamento_id;
        $agenda->delete();
        
        // Atualiza numero de sessões tratamento
        $tratamento = Tratamento::findOrFail($tratamento_id);
        $tratamento->sessoes = $tratamento->sessoes - 1;
        $tratamento->save();
        $this->reordenaTodasAsSessoes($tratamento);

        return Redirect::back()->with('success', 'Registro removido.');
    }

    /**
     * Consulta as sessões para determinada data, mostrando painel horários do dia compacto
     */
    public function consultarSessoes()
    {
        $filtro['data_painel']  = brDateToDatabase(Input::get('data_sessao'));
        $filtro['terapeuta_id'] = Input::get('terapeuta_id');
        $agenda = Agenda::horariosDoDia($filtro);
        $horarios = horarios();
        unset($horarios['']);
        $horariosDestaque = horariosDestaque();
        return View::make('agendas.consultarsessoes', compact('agenda', 'horarios', 'horariosDestaque'));
    }

    public function ordenarSessoes()
    {
        $items = Input::get('items');
        if (count($items) > 0) {
            foreach ($items as $key => $item) {
                $data = Agenda::findOrFail($item);
                $data->sessao = $key + 1;
                $data->save();
            }
        }
        return json_encode(array('status' => 'ok'));
    }

    private function reordenaTodasAsSessoes($tratamento)
    {
        $listaSessoes = Agenda::where('tratamento_id', $tratamento->id)->orderBy('id')->get();
        foreach ($listaSessoes as $key => $item) {
            $item->sessao = $key + 1;
            $item->save();
        }
    }

    public function updateStatusMultipleSessions()
    {
        $agendasituacao = Agendasituacao::findOrFail(Input::get('agendasituacao_id'));

        foreach(Input::get('ids') as $id) {
            if ($agenda = Agenda::find($id)) {
                $agenda->agendasituacao_id = $agendasituacao->id;
                $agenda->save();
            }
        }

        return json_encode(array('message' => 'sessões atualizadas'));
    }

    /* Bloqueio */

    public function createBloqueio()
    {
        $rules = Agenda::$rules;
        $terapeutas = array('' => 'Global') + User::terapeutas()->lists('fullName', 'id');
        return View::make('agendas.create-bloqueio', compact('rules', 'terapeutas'));
    }

    public function editBloqueio($id)
    {
        $dados = Agenda::findOrFail($id);
        if ($dados->genero != 'bloqueio') {
            return false;
        }
        $rules = Agenda::$rules;
        $terapeutas = array('' => 'Global') + User::terapeutas()->lists('fullName', 'id');
        return View::make('agendas.edit-bloqueio', compact('dados', 'rules', 'terapeutas'));
    }

    public function storeBloqueio()
    {
        $data = Input::all();
        $checkedData = array();

        if (isset($data['data_sessao'])) {
            if (count($data['data_sessao']) == 0) {
                return Redirect::back()->with('fail', 'Data do Bloqueio não informada.');
            }
        } else {
            return Redirect::back()->with('fail', 'Data do Bloqueio não definida.');
        }

        $data['genero'] = 'bloqueio';
        if (empty($data['descricao_bloqueio'])) {
            $data['descricao_bloqueio'] = 'Horário bloqueado';
        }
        if (isset($data['bloquear_atendimentos'])) {
            $data['bloquear_atendimentos'] == 1
                ? $data['bloquear_atendimentos'] = 1
                : $data['bloquear_atendimentos'] = 0;
            $checkedData['bloquear_atendimentos'] = $data['bloquear_atendimentos'];
        }

        $checkedData['terapeuta_id_bloqueio'] = isset($data['terapeuta_id_bloqueio']) ? $data['terapeuta_id_bloqueio'] : '';

        foreach ($data['data_sessao'] as $key => $value) {
            
            $data_sessao = brDateToDatabase($value);
            $inicio = isset($data['inicio'][$key]) ? $data['inicio'][$key] : '';
            $fim = isset($data['fim'][$key]) ? $data['fim'][$key] : '';

            if (empty($fim)) {
                if ($inicio == '22:00:00') {
                    $fim = '22:00:00';
                } else {
                    $timestamp   = strtotime($inicio) + 60*60;
                    $time        = date('H:i:s', $timestamp);
                    $fim = $time;
                }
            }

            $checkedData['data_sessao'] = $data_sessao;
            $checkedData['inicio'] = $inicio;
            $checkedData['fim'] = $fim;
            $checkedData['genero'] = $data['genero'];
            $checkedData['descricao_bloqueio'] = $data['descricao_bloqueio'];

            Agenda::create($checkedData);
        }

        return Redirect::back()->with('success', 'Bloqueio(s) cadastrado(s).');
    }

    public function updateBloqueio($id)
    {
        $dados = Agenda::findOrFail($id);
        $data = Input::all();
        
        if (!empty($data['data_sessao'])) {
            $data['data_sessao'] = brDateToDatabase($data['data_sessao']);
        } else {
            return Redirect::back()->with('fail', 'Data do Bloqueio não informada.');
        }
        if (empty($data['descricao_bloqueio'])) {
            $data['descricao_bloqueio'] = 'Horário bloqueado';
        }
        if (empty($data['fim'])) {
            if ($data['inicio'] == '22:00:00') {
                $data['fim'] = '22:00:00';
            } else {
                $timestamp   = strtotime($data['inicio']) + 60*60;
                $time        = date('H:i:s', $timestamp);
                $data['fim'] = $time;
            }
        }
        if (isset($data['bloquear_atendimentos'])) {
            $data['bloquear_atendimentos'] == 1
                ? $data['bloquear_atendimentos'] = 1
                : $data['bloquear_atendimentos'] = 0;
        }
        $data['genero'] = 'bloqueio';
        $dados->update($data);

        return Redirect::back()->with('success', 'Bloqueio atualizado.');
    }

    public function destroyBloqueio($id)
    {
        User::allowedCredentials(array(10, 30));
        // Apenas quem criou pode excluir, exceto Administrador
        // que pode excluir qualquer bloqueio.
        $dados = Agenda::findOrFail($id);
        if (Auth::user()->credential == 10 || $dados->created_by == Auth::user()->id) {
            $dados->delete();
            return Redirect::back()->with('success', 'Bloqueio removido.');
        }
        else {
            return Redirect::back()->with('fail', 'Somente Administrador ou Autor do bloqueio tem permissão para exclusão.');
        }
    }



    /* Agendamento */

    public function createAgendamento()
    {
        $rules = Agenda::$rules;
        $terapeutas = User::terapeutas()->lists('fullName', 'id');
        return View::make('agendas.create-agendamento', compact('rules', 'terapeutas'));
    }

    public function editAgendamento($id)
    {
        $dados = Agenda::findOrFail($id);
        if ($dados->genero != 'agendamento') {
            return false;
        }
        $rules = Agenda::$rules;
        $terapeutas = User::terapeutas()->lists('fullName', 'id');
        return View::make('agendas.edit-agendamento', compact('dados', 'rules', 'terapeutas'));
    }

    public function storeAgendamento()
    {
        $data = Input::all();
        return $this->saveAgendamento($data);
    }

    public function updateAgendamento($id)
    {
        $data = Input::all();
        return $this->saveAgendamento($data, $id);
    }

    public function destroyAgendamento($id)
    {
        User::allowedCredentials(array(10));
        // Apenas quem criou pode excluir, exeto Administrador
        // que pode excluir qualquer agendamento.
        $dados = Agenda::findOrFail($id);
        if (Auth::user()->credential == 10 || $dados->created_by == Auth::user()->id) {
            $dados->delete();
            return Redirect::back()->with('success', 'Agendamento removido.');
        } else {
            return Redirect::back()->with('fail', 'Somente Administrador ou Autor do agendamento tem permissão para exclusão.');
        }
    }

    public function whatsapp($id) 
    {
        $dados = Agenda::findOrFail($id);
        if ($dados->genero != 'atendimento') {
            return false;
        }
        
        $horario = horarios()[$dados->inicio];
        $fone = $dados->tratamento->paciente->fone_celular;
        $url = 'https://wa.me/';
        $texts = [
            ['label' => 'Lembrete Agenda', 'text' => "?text=Olá {$dados->tratamento->paciente->nome}. Lembramos que o seu atendimento está marcado para *{$dados->data_sessao}* às *$horario*. Aguardamos sua confirmação."],
            ['label' => 'Nova Mensagem', 'text' => '']
        ];
        return View::make('agendas.whatsapp', compact('dados', 'fone', 'url', 'texts'));
    }

    private function saveAgendamento($data = array(), $id = null)
    {
        if (!empty($data['data_sessao'])) {
            $data['data_sessao'] = brDateToDatabase($data['data_sessao']);
        } else {
            return Redirect::back()->with('fail', 'Data do Agendamento não informada.');
        }
        if (empty($data['fim'])) {
            if ($data['inicio'] == '22:00:00') {
                $data['fim'] = '22:00:00';
            }
            else {
                $timestamp = strtotime($data['inicio']) + 60 * 60;
                $time = date('H:i:s', $timestamp);
                $data['fim'] = $time;
            }
        }
        $data['genero'] = 'agendamento';

        if (!is_null($id)) {
            $dados = Agenda::findOrFail($id);
            $dados->update($data);
        }
        else {
            Agenda::create($data);
        }

        return Redirect::back()->with('success', 'Agendamendo registrado.');
    }
}
