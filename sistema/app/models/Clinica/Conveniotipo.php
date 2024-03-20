<?php

class Conveniotipo extends \Eloquent
{
    use SoftDeletingTrait;
    protected $dates = array('deleted_at');

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'conveniotipos';

    // Add your validation rules here
    public static $rules = array(
        'nome' => 'required',
        'lancamento_automatico' => 'required',
    );

    // Don't forget to fill this array
    protected $fillable = array('nome', 'lancamento_automatico');

    public function setNomeAttribute($value)
    {
        $this->attributes['nome'] = trim($value);
    }

    public function convenios()
    {
        return $this->hasMany('Convenio');
    }
}
