<?php

class Tratamentonotificacao extends \Eloquent
{
    use SoftDeletingTrait;
    protected $dates = array('deleted_at');

    protected $table = 'tratamentonotificacoes';

    // Add your validation rules here
    public static $rules = array(
        'tratamento_id' => 'required',
    );

    // Don't forget to fill this array
    protected $fillable = array(
        'tratamento_id', 'mensagem', 'lido',
    );

    public function tratamento()
    {
        return $this->belongsTo('Tratamento')->withTrashed();
    }

    public function setTratamentoIdAttribute($value)
    {
        $this->attributes['tratamento_id'] = empty(trim($value)) ? null : $value;
    }

    public static function listagem($id)
    {
        return self::with('tratamento')
            ->where('tratamento_id', '=', $id)
            ->orderBy('created_at', 'DESC')
            ->get();
    }
}
