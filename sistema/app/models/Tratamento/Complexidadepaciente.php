<?php

class Complexidadepaciente extends \Eloquent
{
    protected $table = 'complexidadepacientes';
    protected $orderBy = 'created_at'; // manter em ordem crescente (asc)

    public static $rules = array(
        'complexidade_id' => 'required',
        'paciente_id' => 'required',
    );

    protected $fillable = array(
        'complexidade_id',
        'paciente_id',
    );


    public static function boot()
    {
        parent::boot();

        if (Auth::user()) {
            static::creating(function($table) {
                if (Auth::user()) {
                    $table->created_by = Auth::user()->id;
                }
            });
        }
    }


    public function complexidade()
    {
        return $this->belongsTo('Complexidade');
    }

    public function paciente()
    {
        return $this->belongsTo('Paciente');
    }

    public function createdBy()
    {
        return $this->belongsTo('User', 'created_by', 'id')->withTrashed();
    }

    public function getCreatedAtAttribute($value)
    {
        return timestampToBr($value);
    }


    public function setComplexidadeIdAttribute($value)
    {
        $this->attributes['complexidade_id'] = empty(trim($value)) ? null : $value;
    }

    public function setPacienteIdAttribute($value)
    {
        $this->attributes['paciente_id'] = empty(trim($value)) ? null : $value;
    }
}
