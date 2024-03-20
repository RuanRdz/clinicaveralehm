<?php

class Tratamentosituacao extends \Eloquent
{
    use SoftDeletingTrait;
    protected $dates = array('deleted_at');

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table   = 'tratamentosituacoes';
    protected $orderBy = 'id';

    // Add your validation rules here
    public static $rules = array(
        'nome' => 'required',
        'bg_color' => 'required',
    );

    // Don't forget to fill this array
    protected $fillable = array('nome', 'bg_color');

    public function tratamentos()
    {
        return $this->hasMany('Tratamento');
    }

    public function setNomeAttribute($value)
    {
        $this->attributes['nome'] = trim($value);
    }
}
