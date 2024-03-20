<?php

class Textosprontuario extends \Eloquent
{
    use SoftDeletingTrait;
    protected $dates = array('deleted_at');

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'textosprontuario';

    // Add your validation rules here
    public static $rules = array(
        'nome' => 'required',
        'ordem' => 'required',
    );

    // Don't forget to fill this array
    protected $fillable = array('nome', 'conteudo', 'ordem');

    protected $appends = array('conteudo_html');
    
    public static function autocomplete($term)
    {
        return self::where('nome', 'LIKE', '%'.$term.'%')->get();
    }

    public function getConteudoHtmlAttribute()
    {
        return nl2br($this->attributes['conteudo']);
    }
}
