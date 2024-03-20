<?php

class Tabelaforca extends \Eloquent
{
    protected $table = 'tabelaforca';

    public static $rules = array(
        'tratamento_id' => 'required',
        'data_sessao' => 'required',
    );

    protected $fillable = array(
        'tratamento_id', 'data_sessao',
        'f1d', 'f1e',
        'f2d', 'f2e',
        'f3d', 'f3e',
        'f4d', 'f4e',
    );

    public function tratamento()
    {
        return $this->belongsTo('Tratamento');
    }

    public function getDataSessaoAttribute($value)
    {
        return timestampToBr($value);
    }

    public function setDataSessaoAttribute($value)
    {
        if ($value == '0000-00-00' || empty($value)) {
            $value = null;
        }
        $this->attributes['data_sessao'] = brDateToDatabase($value);
    }

    public function setTratamentoIdAttribute($value)
    {
        $this->attributes['tratamento_id'] = empty(trim($value)) ? null : $value;
    }

    public function setF1dAttribute($value)
    {
        $this->attributes['f1d'] = $value ?: null;
    }
    public function setF1eAttribute($value)
    {
        $this->attributes['f1e'] = $value ?: null;
    }
    public function setF2dAttribute($value)
    {
        $this->attributes['f2d'] = $value ?: null;
    }
    public function setF2eAttribute($value)
    {
        $this->attributes['f2e'] = $value ?: null;
    }
    public function setF3dAttribute($value)
    {
        $this->attributes['f3d'] = $value ?: null;
    }
    public function setF3eAttribute($value)
    {
        $this->attributes['f3e'] = $value ?: null;
    }
    public function setF4dAttribute($value)
    {
        $this->attributes['f4d'] = $value ?: null;
    }
    public function setF4eAttribute($value)
    {
        $this->attributes['f4e'] = $value ?: null;
    }

    public static function listagem(Tratamento $t)
    {
        $flagAnteriores = in_array('TF', explode(',', $t->anexar_anteriores));
        if ($flagAnteriores) {
            return Tabelaforca::join('tratamentos', 'tabelaforca.tratamento_id', '=', 'tratamentos.id')
                ->select(
                    'tabelaforca.id',
                    'tabelaforca.tratamento_id',
                    'tabelaforca.data_sessao',
                    'f1d',
                    'f1e',
                    'f2d',
                    'f2e',
                    'f3d',
                    'f3e',
                    'f4d',
                    'f4e',
                    'tabelaforca.created_at',
                    'tabelaforca.updated_at'
                )
                ->where('tratamentos.paciente_id', '=', $t->paciente_id)
                ->where('tratamentos.lesao_id', '=', $t->lesao_id)
                ->where('tabelaforca.tratamento_id', '<=', $t->id)
                ->orderBy('tabelaforca.data_sessao', 'asc')
                ->get();
        } else {
            return Tabelaforca::where('tratamento_id', '=', $t->id)
                ->orderBy('data_sessao', 'asc')
                ->get();
        }
    }

    public static function listagemLayout(Tratamento $t)
    {
        return Tabelaforca::listagem($t);
    }
}
