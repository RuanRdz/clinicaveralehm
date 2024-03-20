<?php

class Workspace extends \Eloquent
{
    use SoftDeletingTrait;
    protected $dates = array('deleted_at');

    // Add your validation rules here
    public static $rules = array(
        'nome' => 'required',
        'visivel' => 'required|in:1,0',
    );

    // Don't forget to fill this array
    protected $fillable = array('nome', 'visivel');

    public static $opcoesVisivel = array(1 => 'Sim', 0 => 'Não');

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

    public function users()
    {
        return $this->belongsToMany('User')->withTrashed();
    }

    public static function visiveis()
    {
        return self::where('visivel', '=', 1)->get();
    }

    public static function terapeutas($id)
    {
        return self::findOrFail($id)
            ->users
            ->filter(function ($user) {
                return $user->credential == 20 ? true : false;
            });
    }
}
