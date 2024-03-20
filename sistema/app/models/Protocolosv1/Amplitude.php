<?php

class Amplitude extends \Eloquent
{
    use SoftDeletingTrait;
    protected $dates = array('deleted_at');

    protected $table   = 'amplitudes';
    protected $orderBy = 'nome';

    public static $rules = array(
        'nome' => 'required',
        'parametro' => 'required',
        'amplitudegrupo_id' => 'required',
    );

    protected $fillable = array(
        'nome', 'parametro', 'amplitudegrupo_id'
    );

    public function amplitudegrupo()
    {
        return $this->belongsTo('Amplitudegrupo')->withTrashed();
    }
    public function amplitudetratamentos()
    {
        return $this->hasMany('Amplitudetratamento');
    }

    public function setAmplitudegrupoIdAttribute($value)
    {
        $this->attributes['amplitudegrupo_id'] = empty(trim($value)) ? null : $value;
    }

    public static function blocosPorGrupo()
    {
        $dados  = array();
        $grupos = Amplitudegrupo::get();
        foreach ($grupos as $grupo) {
            $itens = self::where('amplitudegrupo_id', '=', $grupo->id)
                ->orderBy('nome')
                ->get();
            if (count($itens) > 0) {
                $dados[] = array(
                    'grupo' => $grupo->nome,
                    'itens' => $itens,
                );
            }
        }

        return $dados;
    }

    public static function selectBox()
    {
        $dados      = array('' => '');
        $amplitudes = self::blocosPorGrupo();
        foreach ($amplitudes as $key => $values) {
            $itens = $values['itens'];
            foreach ($itens as $row) {
                $dados[$values['grupo']][$row->id] = $row->nome.' ('.$row->parametro.')';
            }
        }

        return $dados;
    }
}
