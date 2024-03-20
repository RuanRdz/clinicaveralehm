<?php

class Testeforcatratamento extends \Eloquent
{
    protected $table = 'testeforcatratamentos';

    public static $rules = array(
        'tratamento_id' => 'required|integer',
        'testeforca_id' => 'required|integer',
        'data_sessao' => 'required',
        'grau' => 'required|in:0,1,2,3,4,5',
    );

    protected $fillable = array(
        'tratamento_id', 'testeforca_id',
        'data_sessao', 'grau',
    );

    public function testeforca()
    {
        return $this->belongsTo('Testeforca');
    }

    public function tratamento()
    {
        return $this->belongsTo('Tratamento');
    }

    public function getDataSessaoAttribute($value)
    {
        return timestampToBr($value);
    }

    public function setTratamentoIdAttribute($value)
    {
        $this->attributes['tratamento_id'] = empty(trim($value)) ? null : $value;
    }

    public function setTesteforcaIdAttribute($value)
    {
        $this->attributes['testeforca_id'] = empty(trim($value)) ? null : $value;
    }

    public function setDataSessaoAttribute($value)
    {
        if ($value == '0000-00-00' || empty($value)) {
            $value = null;
        }
        $this->attributes['data_sessao'] = brDateToDatabase($value);
    }

    public static $graus = array(0, 1, 2, 3, 4, 5);


    public static function listagem(Tratamento $t)
    {
        $flagAnteriores = in_array('TFM', explode(',', $t->anexar_anteriores));
        if ($flagAnteriores) {
            return self::join('testeforca', 'testeforca.id', '=', 'testeforcatratamentos.testeforca_id')
                ->join('tratamentos', 'tratamentos.id', '=', 'testeforcatratamentos.tratamento_id')
                ->select(
                    'testeforcatratamentos.id',
                    'testeforcatratamentos.tratamento_id',
                    'testeforcatratamentos.testeforca_id',
                    'testeforcatratamentos.data_sessao',
                    'testeforcatratamentos.grau',
                    'testeforca.nome',
                    'testeforca.descricao',
                    'testeforca.categoria',
                    'testeforca.ordem'
                )
                ->where('tratamentos.paciente_id', '=', $t->paciente_id)
                ->where('tratamentos.lesao_id', '=', $t->lesao_id)
                ->where('testeforcatratamentos.tratamento_id', '<=', $t->id)
                ->orderBy('testeforca.ordem')
                ->orderBy('testeforcatratamentos.data_sessao', 'asc')
                ->get();
        } else {
            return self::join('testeforca', 'testeforca.id', '=', 'testeforcatratamentos.testeforca_id')
                ->select(
                    'testeforcatratamentos.id',
                    'testeforcatratamentos.tratamento_id',
                    'testeforcatratamentos.testeforca_id',
                    'testeforcatratamentos.data_sessao',
                    'testeforcatratamentos.grau',
                    'testeforca.nome',
                    'testeforca.descricao',
                    'testeforca.categoria',
                    'testeforca.ordem'
                )
                ->where('testeforcatratamentos.tratamento_id', '=', $t->id)
                ->orderBy('testeforca.ordem')
                ->orderBy('testeforcatratamentos.data_sessao', 'asc')
                ->get();
        }

    }

    public static function listagemLayout(Tratamento $t)
    {
        $listagem = Testeforcatratamento::listagem($t);

        $categorias = Testeforca::$categorias;
        $dados      = array();
        foreach ($listagem as $row) {
            $grupo     = $categorias[$row->testeforca->categoria];
            $movimento = $row->testeforca->descricao;
            $musculo   = $row->testeforca->nome;
            $data      = $row->data_sessao;
            $grau      = $row->grau;
            $dados
                [$grupo]
                [$movimento]
                [$musculo]
                [] = array(
                    'data' => $data,
                    'grau' => $grau,
                );
        }
        return $dados;
    }
}
