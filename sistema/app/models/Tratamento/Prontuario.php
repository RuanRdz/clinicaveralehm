<?php

class Prontuario extends \Eloquent
{
    use SoftDeletingTrait;
    protected $dates = array('deleted_at');

    protected $table = 'prontuario';
    protected $orderBy = 'dataprontuarioid';

    protected $fillable = array(
        'paciente_id', 'tratamento_id', 'terapeuta_id', 'descricao', 'dataprontuario', 'alta',
    );

    public static $rules = array(
        'paciente_id'    => 'required|integer',
        // 'terapeuta_id'   => 'required|integer', Incluido no controller..
        'descricao'      => 'required',
        'dataprontuario' => 'required',
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
            static::updating(function($table) {
                if (Auth::user()) {
                    $table->updated_by = Auth::user()->id;
                }
            });
        }
    }

    public function paciente()
    {
        return $this->belongsTo('Paciente')->withTrashed();
    }
    
    public function terapeuta()
    {
        return $this->belongsTo('User', 'terapeuta_id', 'id')->withTrashed();
    }
    public function complexidade()
    {
        return $this->belongsTo('Complexidade')->withTrashed();
    }
    public function createdBy()
    {
        return $this->belongsTo('User', 'created_by', 'id')->withTrashed();
    }
    public function updatedBy()
    {
        return $this->belongsTo('User', 'updated_by', 'id')->withTrashed();
    }

    public function getDataprontuarioAttribute($value)
    {
        return timestampToBr($value);
    }

    public function setDataprontuarioAttribute($value)
    {
        if ($value == '0' || $value == '0000-00-00' || empty($value)) {
            $value = null;
        }
        $this->attributes['dataprontuario'] = brDateToDatabase($value);
    }

    public function setAltaAttribute($value)
    {
        $this->attributes['alta'] = empty($value) ? $value = 0 : $value = 1;
    }

    public function setPacienteIdAttribute($value)
    {
        $this->attributes['paciente_id'] = empty(trim($value)) ? null : $value;
    }

    public function setTerapeutaIdAttribute($value)
    {
        $this->attributes['terapeuta_id'] = empty(trim($value)) ? null : $value;
    }

    public function checkTimeLimitToUpdate()
    {
        $date = strtotime($this->created_at);
        $dateLimit = strtotime('-48 hours', time());
        return $date <= $dateLimit ? false : true;
    }

    public static function listagem($tratamento_id)
    {
        return self::with('tratamento')
            ->where('tratamento_id', '=', $tratamento_id)
            ->orderBy('created_at', 'DESC')
            ->get();
    }
}
