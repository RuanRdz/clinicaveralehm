<?php

class Formapagamento extends \Eloquent
{
    use SoftDeletingTrait;
    protected $dates = array('deleted_at');

    protected $table   = 'formapagamento';
    protected $orderBy = 'nome';

    public static $rules = array(
        'nome' => 'required',
    );

    protected $fillable = array('nome', 'taxa');

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
