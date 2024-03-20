<?php

class Agendalog extends \Eloquent {

    public static $rules = array(
        'descricao' => 'required',
        'tratamento_id' => 'required|integer',
    );

	protected $fillable = [
        'tratamento_id',
        'descricao',
    ];

    public function tratamento()
    {
        return $this->belongsTo('Tratamento')->withTrashed();
    }

    public function setTratamentoIdAttribute($value)
    {
        $this->attributes['tratamento_id'] = empty(trim($value)) ? null : $value;
    }

    /**
     * Registra alterações na agenda.
     * @param  Agenda $agenda
     * @param  array $data dados do formulário (post)
     */
    public static function registrar(Agenda $agenda, $data)
    {
        if (isset($data['agendasituacao_id'])) {
            if ($agenda->agendasituacao_id != $data['agendasituacao_id']) {
                $descricao = Auth::user()->name.' alterou Situação da sessão '.$agenda->sessao;
                $descricao.= ' de: '.$agenda->agendasituacao->nome;
                $descricao.= ' para: '.Agendasituacao::lists('nome', 'id')[$data['agendasituacao_id']];
                Agendalog::create([
                    'tratamento_id' => $agenda->tratamento_id,
                    'descricao' => $descricao,
                ]);
            }
        }

        if (isset($data['data_sessao'])) {
            if ($agenda->data_sessao != $data['data_sessao']) {
                if (empty($agenda->data_sessao)) {
                    $descricao = Auth::user()->name.' definiu Data da sessão '.$agenda->sessao;
                    $descricao.= ' para: '.$data['data_sessao'];
                } else {
                    $descricao = Auth::user()->name.' alterou Data da sessão '.$agenda->sessao;
                    $descricao.= ' de: '.$agenda->data_sessao;
                    $descricao.= ' para: '.$data['data_sessao'];
                }
                Agendalog::create([
                    'tratamento_id' => $agenda->tratamento_id,
                    'descricao' => $descricao,
                ]);
            }
        }

        if (isset($data['inicio'])) {
            if ($agenda->inicio != $data['inicio']) {
                if (empty($agenda->inicio)) {
                    $descricao = Auth::user()->name.' definiu Horário da sessão '.$agenda->sessao;
                    $descricao.= ' para: '.$data['inicio'];
                } else {
                    $descricao = Auth::user()->name.' alterou Horário da sessão '.$agenda->sessao;
                    $descricao.= ' de: '.$agenda->inicio;
                    $descricao.= ' para: '.$data['inicio'];
                }
                Agendalog::create([
                    'tratamento_id' => $agenda->tratamento_id,
                    'descricao' => $descricao,
                ]);
            }
        }

        if (isset($data['fim'])) {
            if ($agenda->fim != $data['fim']) {
                if (empty($agenda->fim)) {
                    $descricao = Auth::user()->name.' definiu Horário final da sessão '.$agenda->sessao;
                    $descricao.= ' para: '.$data['fim'];
                } else {
                    $descricao = Auth::user()->name.' alterou Horário final da sessão '.$agenda->sessao;
                    $descricao.= ' de: '.$agenda->fim;
                    $descricao.= ' para: '.$data['fim'];
                }
                Agendalog::create([
                    'tratamento_id' => $agenda->tratamento_id,
                    'descricao' => $descricao,
                ]);
            }
        }
    }

    public static function registrarEmailsEnviadosGuia(Tratamento $t)
    {
        $descricao = Auth::user()->name.' enviou E-mail Guia';
        $descricao.= ' para: '.$t->paciente->nome;
        Agendalog::create([
            'tratamento_id' => $t->id,
            'descricao' => $descricao,
        ]);
    }
}
