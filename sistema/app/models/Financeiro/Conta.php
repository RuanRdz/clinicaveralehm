<?php

class Conta extends \Eloquent
{
    use SoftDeletingTrait;
    protected $dates = array('deleted_at');

    protected $table = 'contas';
    protected $orderBy = 'nome';

    public static $rules = array(
        'banco_id' => 'required',
        'nome' => 'required',
        'valor_saldo' => 'required',
        'data_saldo' => 'required',
    );

    protected $fillable = array(
        'banco_id', 'nome', 'agencia', 'conta'
    );

    public function banco()
    {
        return $this->belongsTo('Banco')->withTrashed();
    }

    public function financeiros()
    {
        return $this->hasMany('Financeiro');
    }

    public function saldos()
    {
        return $this->hasMany('Saldo');
    }

    public function getNomeAttribute($value)
    {
        return mb_strtoupper($value, 'UTF-8');
    }

    public function setBancoIdAttribute($value)
    {
        $this->attributes['banco_id'] = empty(trim($value)) ? null : $value;
    }

    public function setNomeAttribute($value)
    {
        $this->attributes['nome'] = trim(mb_strtoupper($value, 'UTF-8'));
    }

    public function loadSaldoInicial()
    {
        return $this->financeiros()
            ->where('saldo_inicial', 1)
            ->where('conta_id', $this->id)
            ->first();
    }

    public function atualizaSaldoInicial($valor, $data)
    {
        $saldoInicial = $this->loadSaldoInicial();
        
        $data = brDateToDatabase($data);

        if ($saldoInicial) {
            $saldoInicial->valor = $valor;
            $saldoInicial->valor_pago = $valor;
            $saldoInicial->emissao = $data;
            $saldoInicial->vencimento = $data;
            $saldoInicial->pagamento = $data;
            $saldoInicial->descricao = 'SALDO INICIAL '.$this->nome;
            $saldoInicial->observacao = 'SALDO INICIAL '.$this->nome;
        } else {
            $saldoInicial = new Financeiro;
            $saldoInicial->conta_id = $this->id;
            $saldoInicial->genero = 'receber-adm';
            $saldoInicial->parcela = 1;
            $saldoInicial->tipo_lancamento = 'individual';
            $saldoInicial->saldo_inicial = 1;
            $saldoInicial->valor = $valor;
            $saldoInicial->valor_pago = $valor;
            $saldoInicial->emissao = $data;
            $saldoInicial->vencimento = $data;
            $saldoInicial->pagamento = $data;
            $saldoInicial->descricao = '# SALDO INICIAL '.$this->nome.' #';
            $saldoInicial->observacao = '# SALDO INICIAL '.$this->nome.' #';
        }
        $saldoInicial->save();
        // Saldo::recalcular($saldoInicial);
    }
}
