<?php

class Tratamento extends \Eloquent
{
    use SoftDeletingTrait;
    protected $dates = array('deleted_at');

    protected $table = 'tratamentos';

    protected $fillable = array(
        'convenio_id',
        'lesao_id',
        'medico_id',
        'membro_id',
        'paciente_id',
        'terapeuta_id',
        'tratamentosituacao_id',
        'tratamentotipo_id',
        'workspace_id',
        'lesao_tratamento',
        'membro_tipo',
        'data_lesao',
        'data_cirurgia',
        'tecnica_cirurgica',
        'sessoes',
        'info_sessoes',
        'valor_sessao',
        'total',
        'faturado',
        'observacoes',
        'laudo',
        'laudo_certificado',
        'fez_avaliacao',
        'report_options',
    );


    // Add your validation rules here
    public static $rules_create = array(
        'workspace_id' => 'required|integer',
        'terapeuta_id' => 'required|integer',
        'paciente_id' => 'required|integer',
        'tratamentotipo_id' => 'required|integer',
        'tratamentosituacao_id' => 'integer',
        'convenio_id' => 'required|integer',
        'sessoes' => 'required|integer|min:1',
        'faturado' => 'in:Y,N',
        'fez_avaliacao' => 'integer',
    );
    public static $rules_update = array(
        'workspace_id' => 'required|integer',
        'terapeuta_id' => 'required|integer',
        'paciente_id' => 'required|integer',
        'tratamentotipo_id' => 'required|integer',
        'tratamentosituacao_id' => 'integer',
        'faturado' => 'in:Y,N',
        'convenio' => 'required',
        'convenio_id' => 'required|integer',
        'medico_id' => 'integer',
        'lesao' => 'required',
        'lesao_id' => 'integer',
        'membro_id' => 'integer',
        'fez_avaliacao' => 'integer',
    );


    public function paciente()
    {
        return $this->belongsTo('Paciente')->withTrashed();
    }
    public function tratamentotipo()
    {
        return $this->belongsTo('Tratamentotipo')->withTrashed();
    }
    public function convenio()
    {
        return $this->belongsTo('Convenio')->withTrashed();
    }
    public function medico()
    {
        return $this->belongsTo('Medico')->withTrashed();
    }
    public function lesao()
    {
        return $this->belongsTo('Lesao')->withTrashed();
    }
    public function membro()
    {
        return $this->belongsTo('Membro')->withTrashed();
    }
    public function tratamentosituacao()
    {
        return $this->belongsTo('Tratamentosituacao')->withTrashed();
    }
    public function workspace()
    {
        return $this->belongsTo('Workspace')->withTrashed();
    }
    public function terapeuta()
    {
        return $this->belongsTo('User', 'terapeuta_id', 'id')->withTrashed();
    }
    public function createdBy()
    {
        return $this->belongsTo('User', 'created_by', 'id')->withTrashed();
    }
    public function updatedBy()
    {
        return $this->belongsTo('User', 'updated_by', 'id')->withTrashed();
    }
    public function terminologias()
    {
        return $this->belongsToMany('Terminologia')->withTimestamps();
        //return $this->belongsToMany('Terminologia')->orderBy('parent_id');
        /*
        return $this
            ->belongsToMany('Terminologia')
            ->withPivot('terminologia_id')
            ->orderBy('parent_id', 'asc');
        */
    }

    public function agendas()
    {
        return $this->hasMany('Agenda');
    }
    public function agendalogs()
    {
        return $this->hasMany('Agendalog');
    }
    public function tratamentonotificacoes()
    {
        return $this->hasMany('Tratamentonotificacao');
    }
    public function financeiro()
    {
        return $this->hasMany('Financeiro');
    }

    public function anamnesetratamento()
    {
        return $this->hasMany('Anamnesetratamento');
    }

    // deprecated
        public function tabelaforca()
        {
            return $this->hasMany('Tabelaforca');
        }
        public function testeforcatratamento()
        {
            return $this->hasMany('Testeforcatratamento');
        }
        public function amplitudetratamento()
        {
            return $this->hasMany('Amplitudetratamento');
        }

        
        
        
    // PROTOCOLS Relationship
    
    public function terminologiatratamento()
    {
        return $this->hasMany('Terminologiatratamento');
    }

    public function avdsData()
    {
        return $this->hasMany(app\models\Protocols\Tests\Avds\Data::class, 'treatment_id', 'id');
    }
    public function d2pData()
    {
        return $this->hasMany(app\models\Protocols\Tests\D2p\Data::class, 'treatment_id', 'id');
    }
    public function diapazaoData()
	{
		return $this->hasMany(app\models\Protocols\Tests\Diapazao\Data::class, 'treatment_id', 'id');
    }
    public function dorData()
	{
		return $this->hasMany(app\models\Protocols\Tests\Dor\Data::class, 'treatment_id', 'id');
	}
    public function estesiometroData()
    {
        return $this->hasMany(app\models\Protocols\Tests\Estesiometro\Data::class, 'treatment_id', 'id');
    }
    public function forcaData()
	{
		return $this->hasMany(app\models\Protocols\Tests\Forca\Data::class, 'treatment_id', 'id');
	}
    public function funcaomuscularData()
	{
		return $this->hasMany(app\models\Protocols\Tests\Funcaomuscular\Data::class, 'treatment_id', 'id');
	}
    public function goniometroData()
	{
		return $this->hasMany(app\models\Protocols\Tests\Goniometro\Data::class, 'treatment_id', 'id');
    }
    public function jebsenData()
	{
		return $this->hasMany(app\models\Protocols\Tests\Jebsen\Data::class, 'treatment_id', 'id');
    }
    public function kapandjiData()
	{
		return $this->hasMany(app\models\Protocols\Tests\Kapandji\Data::class, 'treatment_id', 'id');
	}
    public function pickupData()
	{
		return $this->hasMany(app\models\Protocols\Tests\Pickup\Data::class, 'treatment_id', 'id');
	}


    public static function boot()
    {
        parent::boot();

        if (Auth::user()) {
            static::creating(function($table) {
                $table->created_by = Auth::user()->id;
            });
            static::updating(function($table) {
                $table->updated_by = Auth::user()->id;
            });
        }
    }

    public function getDataLesaoAttribute($value)
    {
        return timestampToBr($value);
    }
    public function getDataCirurgiaAttribute($value)
    {
        return timestampToBr($value);
    }
    public function getSessoesAttribute($value)
    {
        return $value <= 0 ? 1 : $value;
    }
    public function getCreatedAtAttribute($value)
    {
        return timestampToBr($value);
    }
    public function getValorSessaoAttribute($value)
    {
        return valorBr($value);
    }
    public function getTotalAttribute($value)
    {
        return valorBr($value);
    }
    public function getliberadoParaEdicaoAttribute() 
    {
        if ($this->tratamentosituacao_id != 1 && !Auth::user()->isAdmin) {
            return false;
        }
        return true;
    }

    public function getNumSessoesDisponiveis()
    {
        $limite = 0;
        if ($this->convenio) {
            $limite = $this->convenio->limite_sessoes;
        }
        $sessoes = $this->agendas()->count();
        return (int) $limite - (int) $sessoes;
    }

    public function setSessoesAttribute($value)
    {
        if ($value <= 0) {
            $value = 1;
        }
        $this->attributes['sessoes'] = $value;
    }
    public function setDataLesaoAttribute($value)
    {
        if ($value == '0' || $value == '0000-00-00' || empty($value)) {
            $value = null;
        }
        $this->attributes['data_lesao'] = brDateToDatabase($value);
    }
    public function setDataCirurgiaAttribute($value)
    {
        if ($value == '0' || $value == '0000-00-00' || empty($value)) {
            $value = null;
        }
        $this->attributes['data_cirurgia'] = brDateToDatabase($value);
    }
    public function setConvenioIdAttribute($value)
    {
        $this->attributes['convenio_id'] = empty(trim($value)) ? null : $value;
    }
    public function setLesaoIdAttribute($value)
    {
        $this->attributes['lesao_id'] = empty(trim($value)) ? null : $value;
    }
    public function setMedicoIdAttribute($value)
    {
        $this->attributes['medico_id'] = empty(trim($value)) ? null : $value;
    }
    public function setMembroIdAttribute($value)
    {
        $this->attributes['membro_id'] = empty(trim($value)) ? null : $value;
    }
    public function setPacienteIdAttribute($value)
    {
        $this->attributes['paciente_id'] = empty(trim($value)) ? null : $value;
    }
    public function setTerapeutaIdAttribute($value)
    {
        $this->attributes['terapeuta_id'] = empty(trim($value)) ? null : $value;
    }
    public function setTratamentosituacaoIdAttribute($value)
    {
        $this->attributes['tratamentosituacao_id'] = empty(trim($value)) ? null : $value;
    }
    public function setTratamentotipoIdAttribute($value)
    {
        $this->attributes['tratamentotipo_id'] = empty(trim($value)) ? null : $value;
    }
    public function setWorkspaceIdAttribute($value)
    {
        $this->attributes['workspace_id'] = empty(trim($value)) ? null : $value;
    }
    public function setValorSessaoAttribute($value)
    {
        $this->attributes['valor_sessao'] = valorFloat($value);
    }
    public function setTotalAttribute($value)
    {
        $this->attributes['total'] = valorFloat($value);
    }

    // Scopes

    public function scopeworkspace($query, $id)
    {
        return empty($id) ? null : $query->whereWorkspace_id($id);
    }
    public function scopeterapeuta($query, $id)
    {
        return empty($id) ? null : $query->whereTerapeuta_id($id);
    }
    public function scopetratamentotipo($query, $id)
    {
        return empty($id) ? null : $query->whereTratamentotipo_id($id);
    }
    public function scopetratamentosituacao($query, $id)
    {
        return empty($id) ? null : $query->whereTratamentosituacao_id($id);
    }
    public function scopelesao($query, $id)
    {
        return empty($id) ? null : $query->whereLesao_id($id);
    }
    public function scopemembro($query, $id)
    {
        return empty($id) ? null : $query->whereMembro_id($id);
    }
    public function scopeconvenio($query, $id)
    {
        return empty($id) ? null : $query->whereConvenio_id($id);
    }
    public function scopemedico($query, $id)
    {
        return empty($id) ? null : $query->whereMedico_id($id);
    }

    public function scopeperiodo($query, $dates = null)
    {
        if (is_null($dates[0]) || is_null($dates[1])) {
            $dates = array(
                date('Y-m-01'),
                date('Y-m-d', strtotime('last day of this month', time())),
            );
        }
        $query->where(function ($query) use ($dates) {
            $query->whereBetween(
                'created_at', array(
                    $dates[0],
                    $dates[1],
                )
            );
        });
    }

    // Functions

    public static function listagem($filtro)
    {
        if (Auth::user()->credential == 20) {
            $filtro['terapeuta_id'] = Auth::user()->id;
        }

        $withFields = array(
            'paciente', 'tratamentotipo',
            'tratamentosituacao', 'lesao',
            'membro', 'convenio', 'medico',
            'workspace', 'terapeuta',
        );

        return self::with($withFields)
            ->workspace(Session::get('workspace_id'))
            ->terapeuta($filtro['terapeuta_id'])
            ->tratamentotipo($filtro['tratamentotipo_id'])
            ->tratamentosituacao($filtro['tratamentosituacao_id'])
            ->lesao($filtro['lesao_id'])
            ->membro($filtro['membro_id'])
            ->convenio($filtro['convenio_id'])
            ->medico($filtro['medico_id'])
            ->periodo(array(
                $filtro['data_inicial'],
                $filtro['data_final'],
            ))
            ->orderby('created_at')
            ->paginate(100);
    }

    public function setFezAvaliacao()
    {
        if (! $this->fez_avaliacao) {
            $this->fez_avaliacao = 1;
            $this->save();
        }
    }

    public function dataUltimasAvaliacoes()
    {
        if (! $this->id) {
            return false;
        }

        // protocols namespaces
        $datas = array(
            'Avds' => $this->dataUltimaAvaliacaoAvds(),
            'Dor' => $this->dataUltimaAvaliacaoDor(),
            'Estesiometro' => $this->dataUltimaAvaliacaoEstesiometro(),
            'Forca' => $this->dataUltimaAvaliacaoForca(),
            'Funcaomuscular' => $this->dataUltimaAvaliacaoFuncaomuscular(),
            'Goniometro' => $this->dataUltimaAvaliacaoGoniometro(),
            'Jebsen' => $this->dataUltimaAvaliacaoJebsen(),
            'Kapandji' => $this->dataUltimaAvaliacaoKapandji(),
            'Terminologiauniforme' => $this->dataUltimaAvaliacaoTerminologia(),
        );

        return $datas;
    }

    public function dataUltimaAvaliacaoAvds()
    {
        return $this->avdsData()->max('testdate');
    }

    public function dataUltimaAvaliacaoDor()
    {
        return $this->dorData()->max('testdate');
    }

    public function dataUltimaAvaliacaoEstesiometro()
    {
        return $this->estesiometroData()->max('testdate');
    }

    public function dataUltimaAvaliacaoForca()
    {
        return $this->forcaData()->max('testdate');
    }

    public function dataUltimaAvaliacaoFuncaomuscular()
    {
        return $this->funcaomuscularData()->max('testdate');
    }

    public function dataUltimaAvaliacaoGoniometro()
    {
        return $this->goniometroData()->max('testdate');
    }

    public function dataUltimaAvaliacaoJebsen()
    {
        return $this->jebsenData()->max('testdate');
    }

    public function dataUltimaAvaliacaoKapandji()
    {
        return $this->kapandjiData()->max('created_at');
    }

    public function dataUltimaAvaliacaoTerminologia()
    {
        return $this->terminologiatratamento()->max('created_at');
    }


    public function dadosFaturamento()
    {
    	$dados = array();

        if (isset($this->id)) {

            $total = $this->getOriginal('total');
            $valor_sessao = $this->getOriginal('valor_sessao');
            $lancado = DB::table('financeiro')
                ->select(DB::raw('SUM(valor) as valor'))
                ->where('tratamento_id', $this->id)
                ->whereNull('deleted_at')
                ->first()
                ->valor;
            $a_pagar = DB::table('financeiro')
                ->select(DB::raw('SUM(valor) as valor'))
                ->where('tratamento_id', $this->id)
                ->whereNull('pagamento')
                ->whereNull('deleted_at')
                ->first()
                ->valor;
            $saldo_a_lancar = $total - $lancado;
            $excedeu = '';
            if ($saldo_a_lancar < 0) {
                $excedeu = ' (Excedeu '.valorBr(abs($saldo_a_lancar)).')';
                $saldo_a_lancar = '0.00';
            }
            $total_pago = $lancado - $a_pagar;

            $dados['valor_sessao']        = valorBr($valor_sessao);
            $dados['total']               = valorBr($total);
            $dados['total_lancado']       = valorBr($lancado);
            $dados['saldo_a_lancar']      = valorBr($saldo_a_lancar).$excedeu;
            $dados['lancamentos_a_pagar'] = valorBr($a_pagar);
            $dados['total_pago']          = valorBr($total_pago);
        
        } else {

            $dados['total']               = '0,00';
            $dados['total_lancado']       = '0,00';
            $dados['saldo_a_lancar']      = '0,00';
            $dados['lancamentos_a_pagar'] = '0,00';
            $dados['total_pago']          = '0,00';
        
        }
        
        return $dados;
    }

    public function obterIdUltimaSessao()
    {
        $ultima = $this->agendas()->orderBy('sessao', 'desc')->first();
        if ($ultima) {
            return $ultima->id;
        }
        return null;
    }
}
