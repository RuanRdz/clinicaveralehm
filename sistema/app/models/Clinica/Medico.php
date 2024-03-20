<?php

class Medico extends \Eloquent
{
    use SoftDeletingTrait;
    protected $dates = array('deleted_at');

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'medicos';

    // Add your validation rules here
    public static $rules = array(
        'nome' => 'required',
    );

    // Don't forget to fill this array
    protected $fillable = array(
        'nome',
        'cpf',
        'crm',
        'telefone',
        'endereco',
    );

    public function getNomeAttribute($value)
    {
        return mb_strtoupper($value, 'UTF-8');
    }
    public function setNomeAttribute($value)
    {
        $this->attributes['nome'] = trim(mb_strtoupper($value, 'UTF-8'));
    }

    public function getEnderecoAttribute($value)
    {
        return mb_strtoupper($value, 'UTF-8');
    }
    public function setEnderecoAttribute($value)
    {
        $this->attributes['endereco'] = trim(mb_strtoupper($value, 'UTF-8'));
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
