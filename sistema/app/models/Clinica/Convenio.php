<?php

class Convenio extends \Eloquent
{
    use SoftDeletingTrait;
    protected $dates = array('deleted_at');

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'convenios';

    // Add your validation rules here
    public static $rules = array(
        'nome' => 'required',
        'conveniotipo_id' => 'required|integer',
        'dia_vencimento' => 'integer|min:1|max:31',
        'limite_sessoes' => 'required|integer|min:1',
    );

    // Don't forget to fill this array
    protected $fillable = array(
        'nome',
        'cidade_id',
        'conveniotipo_id',
        'valor',
        'dia_vencimento',
        'limite_sessoes',
    );

    public function getNomeAttribute($value)
    {
        return mb_strtoupper($value, 'UTF-8');
    }
    public function getValorAttribute($value)
    {
        return valorBr($value);
    }

    public function setNomeAttribute($value)
    {
        $this->attributes['nome'] = trim(mb_strtoupper($value, 'UTF-8'));
    }
    public function setCidadeIdAttribute($value)
    {
        $this->attributes['cidade_id'] = empty(trim($value)) ? null : $value;
    }
    public function setConveniotipoIdAttribute($value)
    {
        $this->attributes['conveniotipo_id'] = empty(trim($value)) ? null : $value;
    }
    public function setDiaVencimentoAttribute($value)
    {
        $this->attributes['dia_vencimento'] = $value ?: null;
    }
    public function setValorAttribute($value)
    {
        $this->attributes['valor'] = valorFloat($value);
    }


    public function cidade()
    {
        return $this->belongsTo('Cidade')->withTrashed();
    }

    public function conveniotipo()
    {
        return $this->belongsTo('Conveniotipo')->withTrashed();
    }

    public function tratamentos()
    {
        return $this->hasMany('Tratamento');
    }

    public static $diasVencimento = array(
        '' => '',
        1 => '01', 2 => '02', 3 => '03',
        4 => '04', 5 => '05', 6 => '06',
        7 => '07', 8 => '08', 9 => '09',
        10 => '10', 11 => '11', 12 => '12',
        13 => '13', 14 => '14', 15 => '15',
        16 => '16', 17 => '17', 18 => '18',
        19 => '19', 20 => '20', 21 => '21',
        22 => '22', 23 => '23', 24 => '24',
        25 => '25', 26 => '26', 27 => '27',
        28 => '28', 29 => '29', 30 => '30',
        31 => '31',
    );

    /*
    public function getValorAttribute($value){
    	return number_format($value, 2, ',', '.');
    }
    */

    public function scopeconveniotipo($query, $id)
    {
        return empty($id) ? $query : $query->whereConveniotipo_id($id);
    }

    public static function autocomplete($term)
    {
        return self::where('nome', 'LIKE', '%'.$term.'%')->get();
    }
}
