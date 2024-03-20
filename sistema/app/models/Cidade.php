<?php

class Cidade extends \Eloquent
{
    use SoftDeletingTrait;
    protected $dates = array('deleted_at');

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table   = 'cidades';
    protected $orderBy = 'nome';

    // Add your validation rules here
    public static $rules = array(
        'nome' => 'required',
        'estado' => 'required',
        'estado_uf' => 'required',
        'pais' => 'required',
    );

    // Don't forget to fill this array
    protected $fillable = array(
        'nome', 'slug', 'capital',
        'estado_uf', 'estado', 'pais',
    );

    public function pacientes()
    {
        return $this->hasMany('Paciente');
    }
    public function convenios()
    {
        return $this->hasMany('Convenio');
    }
    public function fornecedores()
    {
        return $this->hasMany('Fornecedor');
    }
    public function financeiro()
    {
        return $this->hasMany('Financeiro');
    }

    public function getNomeAttribute($value)
    {
        return mb_strtoupper($value, 'UTF-8');
    }
    public function getEstadoAttribute($value)
    {
        return mb_strtoupper($value, 'UTF-8');
    }
    public function getPaisAttribute($value)
    {
        return mb_strtoupper($value, 'UTF-8');
    }

    public function setSlugAttribute($value)
    {
        // replace non letter or digits by -
        $value = preg_replace('~[^\\pL\d]+~u', '-', $value);
        // trim
        $value = trim($value, '-');
        // transliterate
        $value = iconv('utf-8', 'us-ascii//TRANSLIT', $value);
        // lowercase
        $value = strtolower($value);
        // remove unwanted characters
        $value = preg_replace('~[^-\w]+~', '', $value);

        $this->attributes['slug'] = $value;
    }
    public function setEstadoUfAttribute($value)
    {
        $this->attributes['estado_uf'] = trim(mb_strtoupper($value, 'UTF-8'));
    }

    public static function autocomplete($term)
    {
        return self::where('nome', 'LIKE', '%'.$term.'%')->get();
    }
}
