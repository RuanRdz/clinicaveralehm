<?php

class Complexidade extends \Eloquent
{
    use SoftDeletingTrait;
    protected $dates = array('deleted_at');

    protected $table = 'complexidade';

    public static $rules = array(
        'grau' => 'required',
        'nome' => 'required',
    );

    protected $fillable = array('grau', 'nome', 'color', 'bg_color');


    public function complexidadepacientes()
    {
        return $this->hasMany('Complexidadepacientes');
    }

    public function getNomeAttribute($value)
    {
        return mb_strtoupper($value, 'UTF-8');
    }
    public function getGrauAttribute($value)
    {
        return mb_strtoupper($value, 'UTF-8');
    }

    public function getFullName()
    {
        return $this->grau.' - '.$this->nome;
    }

    public function setNomeAttribute($value)
    {
        $this->attributes['nome'] = trim(mb_strtoupper($value, 'UTF-8'));
    }
    public function setGrauAttribute($value)
    {
        $this->attributes['grau'] = trim(mb_strtoupper($value, 'UTF-8'));
    }

    public static function selectBox()
    {
        $data = array('' => '');

        $complexidades = self::all();
        foreach ($complexidades as $obj) {
            $data[$obj->id] = $obj->grau.' - '.$obj->nome;
        }

        return $data;
    }

}
