<?php

class Tarefa extends \Eloquent
{
    use SoftDeletingTrait;
    protected $dates     = array('deleted_at');
    public static $rules = array(
        'mensagem' => 'required',
        'de_user_id' => 'required|integer',
        'para_user_id' => 'required|integer',
        // 'prioridade' => 'required|integer',
    );
    protected $fillable = array(
        'mensagem', 'situacao', 'bg_color',
        'de_user_id', 'para_user_id', 'prioridade'
    );

    public function de()
    {
        return $this->belongsTo('User', 'de_user_id');
    }
    public function para()
    {
        return $this->belongsTo('User', 'para_user_id');
    }

    public static $optionsSituacao = array(
        'aberto' => 'Aberto',
        'finalizado' => 'Finalizado',
    );

    public static $optionsPrioridade = array(
        1  => 'Baixa',
        5  => 'Média',
        10 => 'Alta',
    );

    public static $coresPrioridade = array(
        1  => '#f9f9f9',
        5  => '#FFFDBF',
        10 => '#FFC9BF',
    );

    public function setDeUserIdAttribute($value)
    {
        $this->attributes['de_user_id'] = empty(trim($value)) ? null : $value;
    }

    public function setParaUserIdAttribute($value)
    {
        $this->attributes['para_user_id'] = empty(trim($value)) ? null : $value;
    }

    public static function inbox(User $para)
    {
        return self::with('de', 'para')
            ->whereIn('de_user_id', array($para->id, Auth::user()->id))
            ->whereIn('para_user_id', array($para->id, Auth::user()->id))
            ->orderBy('created_at', 'asc')
            ->get();
    }

    public static function enviadas()
    {
        return self::with('para')
            ->where('de_user_id', '=', Auth::user()->id)
            ->orderBy('created_at', 'desc')
            ->get();
    }

    public static function recebidas()
    {
        return self::with('de')
            ->where('de_user_id', '!=', Auth::user()->id)
            ->where('para_user_id', '=', Auth::user()->id)
            ->orderBy('created_at', 'desc')
            ->get();
    }

    public static function recebidasNaoLidas()
    {
        return self::where('para_user_id', '=', Auth::user()->id)
            ->where('visualizado', '=', 'N')
            ->count();
    }
}
