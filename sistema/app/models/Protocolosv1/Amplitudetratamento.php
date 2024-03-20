<?php

class Amplitudetratamento extends \Eloquent
{
    protected $table   = 'amplitudetratamentos';
    protected $orderBy = 'nome';

    public static $rules = array(
        'data_sessao' => 'required',
        'ativo' => 'required|integer',
        'passivo' => 'required|integer',
        'tratamento_id' => 'required',
        'amplitude_id' => 'required',
        'lado' => 'required|In:-,direito,esquerdo',
    );

    protected $fillable = array(
        'data_sessao', 'ativo', 'passivo',
        'tratamento_id', 'amplitude_id', 'lado',
    );

    public function amplitude()
    {
        return $this->belongsTo('Amplitude')->withTrashed();
    }
    public function Tratamento()
    {
        return $this->belongsTo('Tratamento')->withTrashed();
    }

    public function getDataSessaoAttribute($value)
    {
        return timestampToBr($value);
    }

    public function setTratamentoIdAttribute($value)
    {
        $this->attributes['tratamento_id'] = empty(trim($value)) ? null : $value;
    }

    public function setAmplitudeIdAttribute($value)
    {
        $this->attributes['amplitude_id'] = empty(trim($value)) ? null : $value;
    }

    public function setDataSessaoAttribute($value)
    {
        if ($value == '0000-00-00' || empty($value)) {
            $value = null;
        }
        $this->attributes['data_sessao'] = brDateToDatabase($value);
    }

    public static $lados = array(
        '-' => '-',
        'direito' => 'D',
        'esquerdo' => 'E',
    );

    public static function listagem(Tratamento $t)
    {
        $flagAnteriores = in_array('AM', explode(',', $t->anexar_anteriores));
        if ($flagAnteriores) {
            return self::
                join('amplitudes', 'amplitudes.id', '=', 'amplitudetratamentos.amplitude_id')
                ->join('amplitudegrupos', 'amplitudegrupos.id', '=', 'amplitudes.amplitudegrupo_id')
                ->join('tratamentos', 'tratamentos.id', '=', 'amplitudetratamentos.tratamento_id')
                ->select(
                    'amplitudetratamentos.id',
                    'amplitudetratamentos.tratamento_id',
                    'amplitudetratamentos.amplitude_id',
                    'amplitudetratamentos.lado',
                    'amplitudetratamentos.data_sessao',
                    'amplitudetratamentos.ativo',
                    'amplitudetratamentos.passivo',
                    'amplitudes.nome',
                    'amplitudes.parametro',
                    'amplitudegrupos.nome'
                )
                ->where('tratamentos.paciente_id', '=', $t->paciente_id)
                ->where('tratamentos.lesao_id', '=', $t->lesao_id)
                ->where('amplitudetratamentos.tratamento_id', '<=', $t->id)
                ->orderBy('amplitudegrupos.nome')
                ->orderBy('amplitudes.nome')
                ->orderBy('amplitudetratamentos.data_sessao', 'asc')
                ->get();
        } else {
            return self::
                join('amplitudes', 'amplitudes.id', '=', 'amplitudetratamentos.amplitude_id')
                ->join('amplitudegrupos', 'amplitudegrupos.id', '=', 'amplitudes.amplitudegrupo_id')
                ->select(
                    'amplitudetratamentos.id',
                    'amplitudetratamentos.tratamento_id',
                    'amplitudetratamentos.amplitude_id',
                    'amplitudetratamentos.lado',
                    'amplitudetratamentos.data_sessao',
                    'amplitudetratamentos.ativo',
                    'amplitudetratamentos.passivo',
                    'amplitudes.nome',
                    'amplitudes.parametro',
                    'amplitudegrupos.nome'
                    )
                    ->where('amplitudetratamentos.tratamento_id', '=', $t->id)
                    ->orderBy('amplitudegrupos.nome')
                    ->orderBy('amplitudes.nome')
                    ->orderBy('amplitudetratamentos.data_sessao', 'asc')
                    ->get();
        }
    }

    public static function listagemLayout(Tratamento $t)
    {
        $listagem = Amplitudetratamento::listagem($t);

        $atLados  = Amplitudetratamento::$lados;
        $dados    = array();
        foreach ($listagem as $row) {
            $articulacao = $row->amplitude->amplitudegrupo->nome;
            $movimento   = $row->amplitude->nome;
            $lado        = $atLados[$row->lado];
            $parametro   = $row->amplitude->parametro;
            $data        = $row->data_sessao;
            $ativo 	     = $row->ativo;
            $passivo 	 = $row->passivo;
            $dados
                [$articulacao]
                [$movimento]
                [$lado]
                [$parametro]
                [] = array(
                    'data' => $data,
                    'ativo' => $ativo,
                    'passivo' => $passivo,
                );
        }
        return $dados;
    }
}
