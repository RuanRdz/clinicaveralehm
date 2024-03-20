<?php

class Testeforca extends \Eloquent
{
    use SoftDeletingTrait;
    protected $dates = array('deleted_at');

    protected $table = 'testeforca';

    public static $rules = array(
        'nome' => 'required',
        'descricao' => 'required',
        'categoria' => 'required',
        'ordem' => 'required',
    );

    protected $fillable = array(
        'nome', 'descricao', 'categoria', 'ordem',
    );

    public static $categorias = array(
        'extremidades_superiores' => 'Extremidades superiores',
        'cabeca_pescoco_tronco'   => 'Cabeça, pescoço e tronco',
        'extremidades_inferiores' => 'Extremidades inferiores',

    );

    public function testeforcatratamento()
    {
        return $this->hasMany('Testeforcatratamento');
    }

    public static function blocosPorCategoria()
    {
        foreach (self::$categorias as $key => $value) {
            $dados[$key] = array(
                'categoria' => $value,
                'itens' => self::where('categoria', '=', $key)
                    ->orderBy('ordem')
                    ->get(),
            );
        }

        return $dados;
    }

    public static function autocomplete($term)
    {
        return self::where('nome', 'LIKE', '%'.$term.'%')->get();
    }
}
