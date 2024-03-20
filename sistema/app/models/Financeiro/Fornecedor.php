<?php

class Fornecedor extends \Eloquent
{
    use SoftDeletingTrait;
    protected $dates = array('deleted_at');

    protected $table   = 'fornecedores';
    protected $orderBy = 'nome';

    // Add your validation rules here
    public static $rules = array(
        'nome' => 'required',
        'cpf' => 'unique:fornecedores,cpf',
        'cnpj' => 'unique:fornecedores,cnpj',
        'inscricao_estadual' => 'unique:fornecedores,inscricao_estadual',
    );

    // Don't forget to fill this array
    protected $fillable = array(
        'nome', 'razao_social',
        'cpf', 'cnpj', 'inscricao_estadual',
        'telefone', 'celular', 'operadora_celular',
        'endereco', 'cidade_id', 'email',
    );

    public function cidade()
    {
        return $this->belongsTo('Cidade')->withTrashed();
    }
    public function financeiro()
    {
        return $this->hasMany('Financeiro');
    }

    public function setNomeAttribute($value)
    {
        $this->attributes['nome'] = trim(mb_strtoupper($value, 'UTF-8'));
    }

    public function setRazaoSocialAttribute($value)
    {
        $this->attributes['razao_social'] = trim(mb_strtoupper($value, 'UTF-8'));
    }

    public function setCidadeIdAttribute($value)
    {
        $this->attributes['cidade_id'] = empty(trim($value)) ? null : $value;;
    }

    public function setEmailAttribute($value)
    {
        $this->attributes['email'] = trim(mb_strtolower($value, 'UTF-8'));
    }

    public function setEnderecoAttribute($value)
    {
        $this->attributes['endereco'] = trim(mb_strtoupper($value, 'UTF-8'));
    }

    public function setOperadoraCelularAttribute($value)
    {
        $this->attributes['operadora_celular'] = trim(mb_strtoupper($value, 'UTF-8'));
    }

    /**
     * Cadastro rápido de fornecedor.
     * Cadastra um fornecedor pelo Nome.
     * Para uso no formulário contas a pagar.
     */
    public static function cadastroRapido($nome = 'Nome não informado')
    {
        $fornecedor       = new self();
        $fornecedor->nome = $nome;
        $fornecedor->save();

        return $fornecedor->id;
    }

    public static function autocomplete($term)
    {
        return self::where('nome', 'LIKE', '%'.$term.'%')->get();
    }
}
