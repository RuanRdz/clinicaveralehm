<?php

class Centrocusto extends \Eloquent
{
    use SoftDeletingTrait;
    protected $dates = array('deleted_at');

    protected $table   = 'centrocusto';
    protected $orderBy = 'nome';

    public static $rules = array(
        'nome' => 'required',
    );

    protected $fillable = array('nome');

    public function financeiro()
    {
        return $this->hasMany('Financeiro');
    }

    public function getNomeAttribute($value)
    {
        return mb_strtoupper($value, 'UTF-8');
    }
    public function setNomeAttribute($value)
    {
        $this->attributes['nome'] = trim(mb_strtoupper($value, 'UTF-8'));
    }
}
