<?php

use Carbon\Carbon;

class Paciente extends \Eloquent
{
    use SoftDeletingTrait;
    protected $dates = array('deleted_at');

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'pacientes';

    // Don't forget to fill this array
    protected $fillable = array(
        'cidade_id',
        'nome',
        'email',
        'rg',
        'cpf',
        'naturalidade',
        'etnia',
        'carteirinha',
        'validadecarteirinha',
        'nascimento',
        'local_nascimento',
        'sexo',
        'orientacao_sexual',
        'endereco',
        'cep',
        'fone_residencial',
        'fone_comercial',
        'fone_celular',
        'operadora_celular',
        'fone_recado',
        'profissao',
        'empresa',
        # Media
        'foto',
        # Complemento
        'observacoes',
        'tempo_empresa',
        'num_empresas_trabalhou',
        'tempo_afastamento',
        'gosta_trabalhar_empresa',
        'aspectos_positivos_empresa',
        'aspectos_negativos_empresa',
        'trabalhos_extras',
        'pegou_atestado',
        'acidente_trabalho',
        'acidente_transito',
        'utiliza_motocicleta',
        'reabilitacao_anterior',
        'lesao_anterior',
        'numero_sessoes',
        'doencas_associadas',
        'outros_tratamentos',
        'medicamentos',
        'alergia',
        'afastamento_anterior',
        'peso',
        'altura',
        'fumante',
        'uso_drogas',
        'estado_civil',
        'escolaridade',
        'religiao',
        'atividade_esportiva',
        'outros',
        // 'adquirir_bens',
        // 'hobby',
    );

    // Add your validation rules here
    public static $rules = array(
        'nome' => 'required',
        'cidade' => 'required',
        'cidade_id' => 'required|integer',
        'email' => 'email',
        'rg' => 'required|unique:pacientes,rg',
        'cpf' => 'required|unique:pacientes,cpf',
        'naturalidade' => 'required',
        // 'etnia' => 'required',
        'nascimento' => 'required',
        // 'local_nascimento' => 'required',
        // 'sexo' => 'required',
        // 'orientacao_sexual' => 'required',
        'endereco'  => 'required',
        'estado_civil' => 'required',
        // 'religiao' => 'required',
        // 'carteirinha' => 'required',
        // 'validadecarteirinha' => 'required',
        // 'fone_residencial' => 'required',
        // 'fone_recado' => 'required',
        // 'fone_celular' => 'required',
        // 'operadora_celular' => 'required',
        'profissao' => 'required',
        'empresa' => 'required',
        // 'tempo_empresa' => 'required',
        // 'gosta_trabalhar_empresa' => 'required',
        // 'aspectos_positivos_empresa' => 'required',
        // 'aspectos_negativos_empresa' => 'required',
        // 'num_empresas_trabalhou' => 'required',
        // 'trabalhos_extras' => 'required',
        // 'pegou_atestado' => 'required',
        // 'acidente_trabalho' => 'required',
        // 'tempo_afastamento' => 'required',
        // 'acidente_transito' => 'required',
        // 'utiliza_motocicleta' => 'required',
        // 'afastamento_anterior' => 'required',
        // 'lesao_anterior' => 'required',
        // 'reabilitacao_anterior' => 'required',
        // 'numero_sessoes' => 'required',
        // 'doencas_associadas' => 'required',
        // 'medicamentos' => 'required',
        // 'alergia' => 'required',
        // 'peso' => 'required',
        // 'altura' => 'required',
        // 'escolaridade' => 'required',
        // 'fumante' => 'required',
        // 'uso_drogas' => 'required',
        // 'atividade_esportiva' => 'required',
    );

    public function cidade()
    {
        return $this->belongsTo('Cidade')->withTrashed();
    }
    public function createdBy()
    {
        return $this->belongsTo('User', 'created_by', 'id')->withTrashed();
    }
    public function updatedBy()
    {
        return $this->belongsTo('User', 'updated_by', 'id')->withTrashed();
    }

    public function tratamentos()
    {
        return $this->hasMany('Tratamento');
    }
    public function prontuarios()
    {
        return $this->hasMany('Prontuario');
    }

    public function complexidadepacientes()
    {
        return $this->hasMany('Complexidadepaciente');
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

    public function getNomeAttribute($value)
    {
        return mb_strtoupper($value, 'UTF-8');
    }
    public function setNomeAttribute($value)
    {
        $this->attributes['nome'] = trim(mb_strtoupper($value, 'UTF-8'));
    }

    public function getNascimentoAttribute($value)
    {
        return timestampToBr($value);
    }
    public function setNascimentoAttribute($value)
    {
        if ($value == '0' || $value == '0000-00-00' || empty($value)) {
            $value = null;
        }
        $this->attributes['nascimento'] = brDateToDatabase($value);
    }

    public function getIdadeAttribute($value)
    {
        return Carbon::parse($this->attributes['nascimento'])->age;
    }

    public function getValidadecarteirinhaAttribute($value)
    {
        return timestampToBr($value);
    }
    public function setValidadecarteirinhaAttribute($value)
    {
        if ($value == '0' || $value == '0000-00-00' || empty($value)) {
            $value = null;
        }
        $this->attributes['validadecarteirinha'] = brDateToDatabase($value);
    }

    public function getFoneCelularAttribute($value)
    {
        return preg_replace('/[^0-9]/', '', $value);
    }
    public function setFoneCelularAttribute($value)
    {
        $this->attributes['fone_celular'] = preg_replace('/[^0-9]/', '', $value);
    }

    public function getOperadoraCelularAttribute($value)
    {
        return mb_strtoupper($value, 'UTF-8');
    }
    public function setOperadoraCelularAttribute($value)
    {
        $this->attributes['operadora_celular'] = trim(mb_strtoupper($value, 'UTF-8'));
    }

    public function getEnderecoAttribute($value)
    {
        return mb_strtoupper($value, 'UTF-8');
    }
    public function getEmpresaAttribute($value)
    {
        return mb_strtoupper($value, 'UTF-8');
    }
    public function getProfissaoAttribute($value)
    {
        return mb_strtoupper($value, 'UTF-8');
    }
    public function getEmailAttribute($value)
    {
        return mb_strtolower($value, 'UTF-8');
    }

    public function setEnderecoAttribute($value)
    {
        $this->attributes['endereco'] = trim(mb_strtoupper($value, 'UTF-8'));
    }
    public function setEmpresaAttribute($value)
    {
        $this->attributes['empresa'] = trim(mb_strtoupper($value, 'UTF-8'));
    }
    public function setProfissaoAttribute($value)
    {
        $this->attributes['profissao'] = trim(mb_strtoupper($value, 'UTF-8'));
    }
    public function setEmailAttribute($value)
    {
        $this->attributes['email'] = trim(mb_strtolower($value, 'UTF-8'));
    }

    public function setTempoEmpresaAttribute($value)
    {
        $this->attributes['tempo_empresa'] = trim(mb_strtoupper($value, 'UTF-8'));
    }
    public function setAspectosPositivosEmpresaAttribute($value)
    {
        $this->attributes['aspectos_positivos_empresa'] = trim(mb_strtoupper($value, 'UTF-8'));
    }
    public function setAspectosNegativosEmpresaAttribute($value)
    {
        $this->attributes['aspectos_negativos_empresa'] = trim(mb_strtoupper($value, 'UTF-8'));
    }
    public function setTrabalhosExtrasAttribute($value)
    {
        $this->attributes['trabalhos_extras'] = trim(mb_strtoupper($value, 'UTF-8'));
    }

    public function setAcidenteTransitoAttribute($value)
    {
        $this->attributes['acidente_transito'] = trim(mb_strtoupper($value, 'UTF-8'));
    }
    public function setTempoAfastamentoAttribute($value)
    {
        $this->attributes['tempo_afastamento'] = trim(mb_strtoupper($value, 'UTF-8'));
    }
    public function setAfastamentoAnteriorAttribute($value)
    {
        $this->attributes['afastamento_anterior'] = trim(mb_strtoupper($value, 'UTF-8'));
    }
    public function setLesaoAnteriorAttribute($value)
    {
        $this->attributes['lesao_anterior'] = trim(mb_strtoupper($value, 'UTF-8'));
    }
    public function setReabilitacaoAnteriorAttribute($value)
    {
        $this->attributes['reabilitacao_anterior'] = trim(mb_strtoupper($value, 'UTF-8'));
    }
    public function setDoencasAssociadasAttribute($value)
    {
        $this->attributes['doencas_associadas'] = trim(mb_strtoupper($value, 'UTF-8'));
    }
    public function setMedicamentosAttribute($value)
    {
        $this->attributes['medicamentos'] = trim(mb_strtoupper($value, 'UTF-8'));
    }
    public function setAlergiaAttribute($value)
    {
        $this->attributes['alergia'] = trim(mb_strtoupper($value, 'UTF-8'));
    }
    public function setHobbyAttribute($value)
    {
        $this->attributes['hobby'] = trim(mb_strtoupper($value, 'UTF-8'));
    }
    public function setUsoDrogasAttribute($value)
    {
        $this->attributes['uso_drogas'] = trim(mb_strtoupper($value, 'UTF-8'));
    }
    public function setAtividadeEsportivaAttribute($value)
    {
        $this->attributes['atividade_esportiva'] = trim(mb_strtoupper($value, 'UTF-8'));
    }
    public function setReligiaoAttribute($value)
    {
        $this->attributes['religiao'] = trim(mb_strtoupper($value, 'UTF-8'));
    }
    public function setOutrosAttribute($value)
    {
        $this->attributes['outros'] = trim(mb_strtoupper($value, 'UTF-8'));
    }

    public function setCidadeIdAttribute($value)
    {
        $this->attributes['cidade_id'] = empty(trim($value)) ? null : $value;
    }

    public static $SN   = array('' => '', 'S' => 'SIM', 'N' => 'NÃO');
    public static $sexo = array(
        '' => '', 'F' => 'Feminino', 'M' => 'Masculino',
    );
    public static $estado_civil = array(
        '' => '',
        'SOLTEIRO' => 'SOLTEIRO (a)',
        'CASADO' => 'CASADO (a)',
        'SEPARADO' => 'SEPARADO (a)',
        'DIVORCIADO' => 'DIVORCIADO (a)',
        'VIUVO' => 'VIÚVO (a)',
    );
    public static $escolaridade = array(
        '' => '',
        'FUNDAMENTAL' => 'FUNDAMENTAL',
        'MEDIO' => 'MÉDIO',
        'SUPERIOR' => 'SUPERIOR',
        'ESPECIALIZADO' => 'ESPECIALIZADO',
        'NENHUM' => 'NENHUM',
    );

    public function scopecidade($query, $id)
    {
        return empty($id) ? null : $query->whereCidade_id($id);
    }
    public function scopeempresa($query, $empresa)
    {
        return empty($empresa) ? null : $query->whereEmpresa($empresa);
    }

    public static function listagem()
    {
        $char = Session::get('filtro_pacientes.char');
        return self::with('cidade')
            ->cidade(Session::get('filtro_pacientes.cidade_id'))
            ->empresa(Session::get('filtro_pacientes.empresa'))
            ->where(function ($query) use ($char) {
                if ($char == 'number') {
                    foreach (range(0, 9) as $number) {
                        $query->orWhere('nome', 'like', "$number%");
                    }    
                } else {
                    $query->where('nome', 'like', "$char%");
                }
            })
            ->orderby('pacientes.nome')
            ->paginate(50);
    }

    public static function autocomplete($term)
    {
        return self::where('nome', 'LIKE', '%'.$term.'%')->get();
    }

    public static function uploadFoto($paciente)
    {
        $filename  = time();
        $extension = Input::file('foto')->getClientOriginalExtension();
        $foto      = $filename.'.'.$extension;
        Input::file('foto')->move('img/fotos/', $foto);

        $img = Image::make('img/fotos/'.$foto);
        $img->resize(500, null, function ($constraint) {
            $constraint->aspectRatio();
        });
        $img->crop(400, 400, 50, 15);
        $img->save('img/fotos/'.$foto, 70);

        return $foto;
    }

    public function getFotoAttribute($value)
    {
        if ($value) {
            if (file_exists('img/fotos/'.$value)) {
                return asset('img/fotos/'.$value);
            }
        }
        return asset('img/foto.png');
    }

    public static function deleteFotoAtual($paciente)
    {
        if (isset($paciente->foto)) {
            if (!empty($paciente->foto)) {
                if (file_exists('img/fotos/'.$paciente->foto)) {
                    unlink('img/fotos/'.$paciente->foto);
                }
            }
        }
    }

    public function complexidadeAtual()
    {
        $cp = $this->complexidadepacientes->toArray();
        $complexidadeAtual = last($cp);
        return isset($complexidadeAtual['complexidade']) ? $complexidadeAtual['complexidade'] : null;

        // return $this->complexidadepacientes()
        //     ->orderBy('id', 'desc')
        //     ->first();
    }

    public function checkAvaliacaoMesmaPatologia($lesao_id)
    {
        return $this
            ->tratamentos()
            ->where('lesao_id', '=', $lesao_id)
            ->where('fez_avaliacao', '=', 1)
            ->count();
    }
}
