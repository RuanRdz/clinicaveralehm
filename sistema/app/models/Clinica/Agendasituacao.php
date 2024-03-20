<?php

class Agendasituacao extends \Eloquent
{
    use SoftDeletingTrait;
    protected $dates = array('deleted_at');

    protected $table   = 'agendasituacoes';
    protected $orderBy = 'id';

    public static $rules = array(
        'nome' => 'required',
        'nome_sumario' => 'required',
        'bg_color' => 'required',
    );

    protected $fillable = array('nome', 'nome_sumario', 'bg_color');

    public function agendas()
    {
        return $this->hasMany('Agenda');
    }
}
