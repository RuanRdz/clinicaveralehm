<?php

class Agenda extends \Eloquent
{
    use SoftDeletingTrait;
    protected $dates = array('deleted_at');

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'agendas';

    // Add your validation rules here
    public static $rules = array(
        //'sessao' => 'integer'
        'data_sessao' => 'required',
        'inicio' => 'required',
        //'fim' => 'required',
        'agendasituacao_id' => 'required|integer',
    );

    // Don't forget to fill this array
    protected $fillable = array(
        'tratamento_id',
        'sessao',
        'data_sessao',
        'inicio',
        'fim',
        'genero',

        'agendasituacao_id',
        'descricao_bloqueio',
        'terapeuta_id_bloqueio',
        'bloquear_atendimentos',

        'terapeuta_id_agendamento',
        'nome_agendamento',
        'telefone_agendamento',
        'doenca_agendamento',
        'convenio_agendamento',
        'medico_agendamento',
        'observacao_agendamento',

        'autor',
    );

    public function agendasituacao()
    {
        return $this->belongsTo('Agendasituacao')->withTrashed();
    }
    public function tratamento()
    {
        return $this->belongsTo('Tratamento')->withTrashed();
    }
    public function terapeutabloqueio()
    {
        return $this->belongsTo('User', 'terapeuta_id_bloqueio', 'id')->withTrashed();
    }
    public function terapeutaagendamento()
    {
        return $this->belongsTo('User', 'terapeuta_id_agendamento', 'id')->withTrashed();
    }
    public function createdBy()
    {
        return $this->belongsTo('User', 'created_by', 'id')->withTrashed();
    }
    public function updatedBy()
    {
        return $this->belongsTo('User', 'updated_by', 'id')->withTrashed();
    }
    public static function boot()
    {
        parent::boot();
        
        if (Auth::user()) {
            static::creating(function($table) {
                $table->created_by = Auth::user()->id;
            });
            static::updating(function($table) {
                $table->updated_by = Auth::user()->id;
            });
        }
    }

    public function getDataSessaoAttribute($value)
    {
        return timestampToBr($value);
    }

    public function setAgendasituacaoIdAttribute($value)
    {
        $this->attributes['agendasituacao_id'] = empty(trim($value)) ? null : $value;
    }

    public function setTratamentoIdAttribute($value)
    {
        $this->attributes['tratamento_id'] = empty(trim($value)) ? null : $value;
    }

    public function setTerapeutaIdBloqueioAttribute($value)
    {
        $this->attributes['terapeuta_id_bloqueio'] = empty(trim($value)) ? null : $value;
    }

    public function setTerapeutaIdAgendamentoAttribute($value)
    {
        $this->attributes['terapeuta_id_agendamento'] = empty(trim($value)) ? null : $value;
    }

    public function setDataSessaoAttribute($value)
    {
        if ($value == '0' || $value == '0000-00-00' || empty($value)) {
            $value = null;
        }
        $this->attributes['data_sessao'] = brDateToDatabase($value);
    }

    public function setInicioAttribute($value)
    {
        if ($value == '0' || $value == '00:00:00' || empty($value)) {
            $value = null;
        }
        $this->attributes['inicio'] = $value;
    }
    public function setFimAttribute($value)
    {
        if ($value == '0' || $value == '00:00:00' || empty($value)) {
            $value = null;
        }
        $this->attributes['fim'] = $value;
    }

    public function scopeagendasituacao($query, $id)
    {
        return empty($id) ? null : $query->whereAgendasituacao_id($id);
    }

    public function scopeperiodoControle($query, $datas = null)
    {
        $query->where(function ($query) use ($datas) {
            $query->whereBetween(
                'data_sessao', array($datas[0], $datas[1])
            );
        });
    }

    public function scopefiltroSessoes($query, $filtro)
    {
        switch ($filtro) {
            case 'primeira':
                return $query->where('sessao', '=', 1);
            case 'penultima':
                return $query->where('sessao', '=', DB::raw('tratamentos.sessoes - 1'));
            case 'ultima':
                return $query->where('sessao', '=', DB::raw('tratamentos.sessoes'));
            default: return null;
        }
    }

    public function scopefiltroTerapeuta($query, $terapeuta_id)
    {
        if ($terapeuta_id) {
            return $query->where('tratamentos.terapeuta_id', '=', $terapeuta_id);
        }
        return null;
    }

    public function scopefiltroMedico($query, $medico_id)
    {
        if ($medico_id) {
            return $query->where('tratamentos.medico_id', '=', $medico_id);
        }
        return null;
    }

    public function scopefiltroConvenio($query, $convenio_id)
    {
        if ($convenio_id) {
            return $query->where('tratamentos.convenio_id', '=', $convenio_id);
        }
        return null;
    }

    public function scopefiltroTratamentoTipo($query, $tratamentotipo_id)
    {
        if ($tratamentotipo_id) {
            return $query->where('tratamentos.tratamentotipo_id', '=', $tratamentotipo_id);
        }
        return null;
    }

    public static function horariosDoDia($filtro)
    {
        $workspace_id = Session::get('workspace_id');
        $terapeuta_id = isset($filtro['terapeuta_id']) ? $filtro['terapeuta_id'] : null;
        if (empty($workspace_id) || empty($terapeuta_id)) {
            return [];
        }
        
        $agenda = self::with('agendasituacao')
            ->with(array('tratamento' => function($query) use ($filtro) {
                $query->with(array('agendas' => function($query) {
                    $query->orderBy('sessao', 'asc');
                }));
                $query->with(array('paciente' => function($query) {
                    $query->with(array('complexidadepacientes' => function($query) {
                        $query->with('complexidade');
                    }));
                }));
                $query->with('tratamentonotificacoes');
            }))
            ->where('data_sessao', '=', $filtro['data_painel'])
            ->orderBy('inicio')
            ->orderBy('fim')
            ->get();

        $dados = [];

        if (! $agenda) {
            return $dados;
        }
        foreach ($agenda as $row) {
            switch ($row->genero) {

                case 'atendimento':

                    $tratamento = $row->tratamento;
                    $paciente = $row->tratamento->paciente;
                    $agendasituacao = $row->agendasituacao;

                    if (is_null($tratamento)) { continue 2; }
                    if (is_null($paciente)) { continue 2; }
                    if ($tratamento->workspace_id != $workspace_id) { continue 2; }
                    if ($tratamento->terapeuta_id != $terapeuta_id) { continue 2; }

                    // Não mostra as sessões canceladas (id 6)
                    // @todo criar um scope pra essa regra
                    if ($agendasituacao->id == 6) { continue 2; }

                    $arraySessoes = $tratamento->agendas->toArray();
                    $notificacoes = $row->checkNotificacoesTratamento();
                    $limiteDeFaltas = $row->checkLimiteDeFaltas($arraySessoes);
                    $avaliacoesPendentes = $row->checkAvaliacoesPendentes($arraySessoes);
                    $complexidadeAtual = $paciente->complexidadeAtual();

                    $limiteFaltasCss = $avaPendentesCss = '';
                    if($avaliacoesPendentes) {
                        $avaPendentesCss = 'color: #fff; background: #e53e3e;';
                    }
                    if($limiteDeFaltas) {
                        $limiteFaltasCss = 'border-color: #e53e3e;';
                    }

                    $dados[horarios()[$row->inicio]][] = array(
                        'genero' => 'atendimento',
                        // Agenda
                        'id' => $row->id,
                        'sessao' => $row->sessao,
                        'inicio' => horarios()[$row->inicio],
                        'fim' => horarios()[$row->fim],
                        'situacao_id' => isset($agendasituacao->id) ? $agendasituacao->id : '',
                        'situacao' => isset($agendasituacao->id) ? $agendasituacao->nome : '',
                        'bg_color' => isset($agendasituacao->id) ? $agendasituacao->bg_color : '',
                        // Tratamento
                        'sessoes' => $tratamento->sessoes,
                        'tratamento_id' => $tratamento->id,
                        'dados_tratamento' => $tratamento,
                        'notificacoes' => $notificacoes,
                        'notificacoes_route' => route('tratamentonotificacoes', array('id' => $tratamento->id)),
                        // Paciente
                        'paciente_id' => $paciente->id,
                        'nome' => $paciente->nome,
                        'profissao' => $paciente->profissao,
                        'empresa' => $paciente->empresa,
                        'idade' => $paciente->idade,
                        'fone_celular' => $paciente->fone_celular,
                        'operadora_celular' => $paciente->operadora_celular,
                        'fone_residencial' => $paciente->fone_residencial,
                        'fone_comercial' => $paciente->fone_comercial,
                        'fone_recado' => $paciente->fone_recado,
                        'email' => $paciente->email,
                        'foto' => $paciente->foto,
                        'complexidade' => $complexidadeAtual,
                        // Verificacoes
                        'limite_de_faltas' => $limiteDeFaltas,
                        'limite_de_faltas_css' => $limiteFaltasCss,
                        'avaliacoes_pendentes' => $avaliacoesPendentes,
                        'avaliacoes_pendentes_css' => $avaPendentesCss,
                    );
                    break;

                case 'bloqueio':

                    if ($row->terapeuta_id_bloqueio) {
                        if ($row->terapeuta_id_bloqueio != $terapeuta_id) {
                            continue 2;
                        }
                    }

                    // Bloqueio simples
                    $row->terapeuta_id_bloqueio
                    ? $css_class = 'hdd-bloqueio'
                    : $css_class = 'hdd-bloqueio hdd-global';

                    // Bloqueio com travamento de atendimentos
                    if ($row->bloquear_atendimentos == 1) {
                        $row->terapeuta_id_bloqueio
                        ? $css_class = 'hdd-bloqueio-2'
                        : $css_class = 'hdd-bloqueio-2 hdd-global';
                    }

                    $dados[horarios()[$row->inicio]][] = array(
                        'genero'             => 'bloqueio',
                        'id'                 => $row->id,
                        'inicio'             => horarios()[$row->inicio],
                        'fim'                => horarios()[$row->fim],
                        'situacao'           => 'Bloqueado',
                        'css_class'          => $css_class,
                        'descricao_bloqueio' => $row->descricao_bloqueio,
                        'created_by'         => $row->createdBy->fullName,
                        'autor'              => $row->autor,
                    );
                    break;

                case 'agendamento':

                    if ($row->terapeuta_id_agendamento) {
                        if ($row->terapeuta_id_agendamento != $terapeuta_id) {
                            continue 2;
                        }
                    }

                    $row->terapeuta_id_agendamento
                    ? $css_class = 'hdd-agendamento'
                    : $css_class = 'hdd-agendamento hdd-global';

                    $dados[horarios()[$row->inicio]][] = array(
                        'genero'                 => 'agendamento',
                        'id'                     => $row->id,
                        'inicio'                 => horarios()[$row->inicio],
                        'fim'                    => horarios()[$row->fim],
                        'situacao'               => 'Bloqueado',
                        'css_class'              => $css_class,
                        'nome_agendamento'       => $row->nome_agendamento,
                        'telefone_agendamento'   => $row->telefone_agendamento,
                        'doenca_agendamento'     => $row->doenca_agendamento,
                        'convenio_agendamento'   => $row->convenio_agendamento,
                        'medico_agendamento'     => $row->medico_agendamento,
                        'observacao_agendamento' => $row->observacao_agendamento,
                        'created_by'             => $row->createdBy->fullName,
                        'autor'                  => $row->autor,
                    );
                    break;
            }
        }

        return $dados;
    }

    public static function contagemEntradasSaidas($dados)
    {
        $entradas = $saidas = $total = 0;
        foreach ($dados as $horario => $itens) {
            foreach ($itens as $key => $item) {
                $total++;
                if ($item['genero'] == 'atendimento') {
                    if ($item['sessao'] == 1 || $item['sessao'] == ($item['sessoes'] + 1)) {
                        $entradas++;
                    }
                    if ($item['sessao'] == ($item['sessoes'])) {
                        $saidas++;
                    }
                }
            }
        }
        return [
            'entradas' => $entradas,
            'saidas' => $saidas,
            'total' => $total,
        ];
    }

    /** Não paginar essa consulta */
    public static function controle($filtro)
    {
        if (Auth::user()->credential == 20) {
            $filtro['terapeuta_id'] = Auth::user()->id;
        }

        $withFields = array(
            'tratamento', 
            'agendasituacao', 
            'tratamento.medico', 
            'tratamento.tratamentotipo', 
            'tratamento.convenio'
        );

        switch ($filtro['genero']) {

            case 'atendimento':
                return self::with($withFields)
                    ->join('tratamentos', 'tratamentos.id', '=', 'tratamento_id')
                    ->leftJoin('medicos', 'medicos.id', '=', 'tratamentos.medico_id')
                    ->leftJoin('convenios', 'convenios.id', '=', 'tratamentos.convenio_id')
                    ->leftJoin('tratamentotipos', 'tratamentotipos.id', '=', 'tratamentos.tratamentotipo_id')
                    ->select(
                        'agendas.*',
                        'agendas.id AS id_sessao',
                        'tratamentos.*',
                        'convenios.*'
                    )
                    ->agendasituacao($filtro['agendasituacao_id'])
                    ->periodoControle(array($filtro['data_inicial'], $filtro['data_final']))
                    ->filtroSessoes($filtro['filtro_sessao'])
                    ->filtroTerapeuta($filtro['terapeuta_id'])
                    ->filtroMedico($filtro['medico_id'])
                    ->filtroConvenio($filtro['convenio_id'])
                    ->filtroTratamentoTipo($filtro['tratamentotipo_id'])
                    ->where('tratamentos.workspace_id', '=', Session::get('workspace_id'))
                    ->orderby('data_sessao')
                    ->orderby('inicio')
                    ->get();
                break;

            case 'bloqueio':
                return self::periodoControle(array($filtro['data_inicial'], $filtro['data_final']))
                    ->where('genero', '=', 'bloqueio')
                    ->where('terapeuta_id_bloqueio', '=', $filtro['terapeuta_id'])
                    ->orderby('data_sessao')
                    ->orderby('inicio')
                    ->get();
                break;

            case 'agendamento':
                return self::periodoControle(array($filtro['data_inicial'], $filtro['data_final']))
                    ->where('genero', '=', 'agendamento')
                    ->where('terapeuta_id_agendamento', '=', $filtro['terapeuta_id'])
                    ->orderby('data_sessao')
                    ->orderby('inicio')
                    ->get();
                break;
        }
    }

    // Verifica se é última sessão e 
    // se todas estão status Atendidas (exceto ela mesma "última")
    public function checkUltimaSessaoAtendimentos()
    {
        $idConcluido = 2;
        $tratamento = $this->tratamento;
        $arraySessoes = $tratamento->agendas->toArray();
        if ($this->sessao == $tratamento->sessoes) {
            foreach ($arraySessoes as $key => $s) {
                if ($s['agendasituacao_id'] != $idConcluido && $s['id'] != $this->id) {
                    return 'sessoes-pendentes';
                }
            }
            return 'sessoes-concluidas';
        }
        return ''; // ainda não é a ultima sessão
    }

    /**
     * Contagem de faltas, considerando apenas faltas em sequência
     */
    public function checkLimiteDeFaltas($arraySessoes, $limite = 2)
    {
        $idFalta = 4;
        $idAnterior = null;
        $contagem = 1;
        foreach ($arraySessoes as $dados) {
            if ($idAnterior == null) {
                if ($idFalta == $dados['agendasituacao_id']) {
                    $contagem += 1;
                }
            } else {
                if ($idFalta == $dados['agendasituacao_id'] && $idFalta == $idAnterior) {
                    $contagem += 1;
                    if ($contagem == $limite) {
                        return true;
                    }
                } else {
                    $contagem = 1;
                }
            }
            $idAnterior = $dados['agendasituacao_id'];
        }

        return false;
    }
        
    // Verifica se nenhuma avaliacao foi realizada apos limite de sessoes
    public function checkAvaliacoesPendentes($arraySessoes, $limite = 5)
    {
        $idAtendimentos = 2;
        $contagem = 0;
        foreach ($arraySessoes as $dados) {
            if ($dados['agendasituacao_id'] == $idAtendimentos) {
                $contagem++;
            }
        }

        if ($contagem >= $limite) {
            $fezAvaliacao = $this
                ->tratamento
                ->paciente
                ->checkAvaliacaoMesmaPatologia($this->tratamento->lesao_id);
            if (! $fezAvaliacao) {
                return true;
            }
        }

        return false;
    }

    public function checkNotificacoesTratamento()
    {
        $notificacoes = $this
            ->tratamento
            ->tratamentonotificacoes()
            ->get();
     
        $dados['total'] = 0;
        $dados['nao_lido'] = 0;

        foreach ($notificacoes as $row) {
            $dados['total'] = $dados['total'] + 1;
            if ($row->lido == 'N') {
                $dados['nao_lido'] = $dados['nao_lido'] + 1;
            }
        }

        return $dados;
    }

    public function allowEdit()
    {
        if(($this->agendasituacao_id == 2 || $this->agendasituacao_id == 6) && !Auth::user()->isAdmin) {
            return false;
        }
        return true;
    }

    /**
     * Monta a agenda com base no numero de sessões contratadas no tratamento.
     */
    public static function novoTratamento($tratamento)
    {
        if ($tratamento->sessoes > 0) {
            for ($i = 1; $i <= $tratamento->sessoes; ++$i) {
                self::adicionarData($tratamento, $i);
            }
        }
    }

    /**
     * Atualiza Agenda conforme definido ao editar Tratamento
     */
    public static function atualizar($tratamento)
    {
        $agendas = $tratamento->agendas()->count();
        $sessoes = $tratamento->sessoes;

        if ($sessoes > $agendas) {
            // Adiciona novas sessões
            $i   = $agendas + 1;
            $add = $i + ($sessoes - $agendas);
            for ($i; $i < $add; ++$i) {
                self::adicionarData($tratamento, $i);
            }
        } elseif ($sessoes < $agendas) {

            // Remove sessões excedentes
            $i     = $agendas - $sessoes;
            $datas = $tratamento
                ->agendas()
                ->orderBy('sessao', 'DESC')
                ->take($i)
                ->get();
            foreach ($datas as $row) {
                $row->forceDelete();
            }
        }
    }

    public static function adicionarData($tratamento, $sessao)
    {
        $dados = array(
            'tratamento_id' => $tratamento->id,
            'sessao' => $sessao,
            'data_sessao' => null,
            'inicio' => null,
            'fim' => null,
            'agendasituacao_id' => 1,
        );
        self::create($dados);
    }

    /**
     * Cancela as agendas em com situação "Aberto"
     * se a situação do tratamento for alterada para "Cancelado".
     */
    public static function cancelarAgendas($tratamento_id)
    {
        self::where('tratamento_id', '=', $tratamento_id)
            ->where('agendasituacao_id', '=', 1)
            ->update(array('agendasituacao_id' => 6));
    }

    /**
     * Verifica se o horário escolhido para atendimento não está bloqueado.
     */
    public static function horarioBloqueado($dados)
    {
        $bloqueios = self::where('genero', '=', 'bloqueio')
            ->where('bloquear_atendimentos', '=', 1)
            ->where('data_sessao', '=', brDateToDatabase($dados['data_sessao']))
            ->where(function($query) use ($dados)
            {
                $query->where('terapeuta_id_bloqueio', '=', $dados['terapeuta_id'])
                      ->orWhereNull('terapeuta_id_bloqueio');
            })
            ->get()
            ->toArray();

        // Horários
        if (empty($dados['inicio'])) {
            return false;
        }

        foreach ($bloqueios as $key => $value) {
            if ($dados['inicio'] >= $value['inicio'] && $dados['inicio'] < $value['fim']) {
                return true;
            }
        }
        return false;
    }
}
