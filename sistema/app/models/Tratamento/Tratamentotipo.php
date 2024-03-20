<?php

class Tratamentotipo extends \Eloquent
{
    use SoftDeletingTrait;
    protected $table = 'tratamentotipos';
    protected $dates = array('deleted_at');
    protected $orderBy = 'sequencia';

    // Add your validation rules here
    public static $rules = array(
        'nome' => 'required',
        'sequencia' => 'required|integer',
    );

    // Don't forget to fill this array
    protected $fillable = array('nome', 'sequencia');

    public function setNomeAttribute($value)
    {
        $this->attributes['nome'] = trim($value);
    }

    public function tratamentos()
    {
        return $this->hasMany('Tratamento');
    }
}
