<?php

class Sistema extends \Eloquent
{
    protected $table = 'sistema';
    protected $orderBy = 'id';
    public static $rules = array('descricao' => 'required');
    protected $fillable = array('descricao');

    public static function parametros()
    {
        $sistema = self::all();
        $result  = array();
        foreach ($sistema as $s) {
            $result[$s->chave] = $s->descricao;
        }

        return $result;
    }
}
