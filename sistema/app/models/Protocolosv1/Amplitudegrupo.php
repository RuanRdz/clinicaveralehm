<?php

class Amplitudegrupo extends \Eloquent
{
    use SoftDeletingTrait;
    protected $dates = array('deleted_at');

    protected $table   = 'amplitudegrupos';
    protected $orderBy = 'nome';

    public static $rules = array('nome' => 'required');
    protected $fillable  = array('nome');

    public function amplitudes()
    {
        return $this->hasMany('Amplitude');
    }


    // Remove as siglas MS/MI do início do nome do grupo
    public function getNomeAttribute($value)
    {
        return substr($value, 5);
    }
}
