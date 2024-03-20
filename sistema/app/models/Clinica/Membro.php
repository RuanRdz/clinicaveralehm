<?php

class Membro extends \Eloquent
{
    use SoftDeletingTrait;
    protected $dates = array('deleted_at');

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'membros';

    // Add your validation rules here
    public static $rules = array(
        'nome' => 'required',
    );

    public static $tipoMembro = array(
        '' => '',
        'dominante' => 'Dominante',
        'nao_dominante' => 'Não Dominante',
    );

    // Don't forget to fill this array
    protected $fillable = array('nome');

    public function getNomeAttribute($value)
    {
        return mb_strtoupper($value, 'UTF-8');
    }
    public function setNomeAttribute($value)
    {
        $this->attributes['nome'] = trim(mb_strtoupper($value, 'UTF-8'));
    }

    public function tratamentos()
    {
        return $this->hasMany('Tratamento');
    }

    public static function autocomplete($term)
    {
        return self::where('nome', 'LIKE', '%'.$term.'%')->get();
    }
}
