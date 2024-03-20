<?php

namespace app\models\Protocols\Tests\Terminologiauniforme;

class Terminologiatratamento extends \Eloquent {

    protected $table   = 'terminologia_tratamento';
    protected $orderBy = 'created_at';

	protected $fillable = array(
        'terminologia_id', 'tratamento_id'
    );

    public static $rules = array();


    public function tratamento()
    {
        return $this->belongsTo('Tratamento');
    }

    // Não será feito consultas diretamente por terminologia
    // public function terminologia()
    // {
    //     return $this->belongsTo('Terminologia');
    // }

    public function setTratamentoIdAttribute($value)
    {
        $this->attributes['tratamento_id'] = empty(trim($value)) ? null : $value;
    }

    public function setTerminologiaIdAttribute($value)
    {
        $this->attributes['terminologia_id'] = empty(trim($value)) ? null : $value;
    }
}
