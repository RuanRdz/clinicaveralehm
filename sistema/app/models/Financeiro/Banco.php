<?php

class Banco extends \Eloquent
{
    use SoftDeletingTrait;
    protected $dates = array('deleted_at');

    protected $table   = 'bancos';
    protected $orderBy = 'id';

    // Add your validation rules here
    public static $rules = array(
        'nome' => 'required',
    );

    // Don't forget to fill this array
    protected $fillable = array(
        'nome', 'codigo',
    );

    public function contas()
    {
        return $this->hasMany('Conta');
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
