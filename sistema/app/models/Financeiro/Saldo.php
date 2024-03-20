<?php

use Carbon\Carbon;

class Saldo extends \Eloquent
{
    protected $table = 'saldo';
    protected $orderBy = 'periodo';

    // Add your validation rules here
    public static $rules = array(
        'conta_id' => 'required',
        'periodo' => 'required',
        'saldo' => 'required',
        'previsao' => 'required',
    );

    // Don't forget to fill this array
    protected $fillable = array(
        'conta_id', 'periodo', 'saldo', 'previsao'
    );

    public function conta()
    {
        return $this->belongsTo('Conta');
    }

    /**
     * Recalcula o saldo a partir do saldo inicial
     * 1) O Valor do mês inicial é o próprio saldo inicial.
     * 2) Encontra o lançamento mais recente.
     * 3) Define os períodos.
     * 4) O cálculo inicia a partir do segundo mês, usando o saldo inicial como "valor anterior".
     */
    public static function recalcular(Conta $conta)
    {
        if (empty($conta)) {
            Log::info('Lançamento indefinido');
            return;
        }

        # 1
        $saldoInicialConta = $conta->loadSaldoInicial();
        if (!$saldoInicialConta) {
            Log::error('Saldo inicial da conta não foi definido');
            return;
        }
        $periodoInicial = Carbon::parse($saldoInicialConta->getOriginal('emissao'))->firstOfMonth();
        $ultimoDiaPeriodoInicial = Carbon::parse($saldoInicialConta->getOriginal('emissao'))->lastOfMonth();
        $valorSaldoInicial = (float) $saldoInicialConta->valor;
        $valorPrevisaoInicial = (float) $saldoInicialConta->valor;

        # 2
        // A data final não deve ultrapassar dois meses a partir do final do ano atual
        $dataLimite = Carbon::parse(date('Y-12-31'))->addMonths(2)->lastOfMonth()->toDateString(); 
        // Conta último lançamento
        ($qUltimoVencimento = Financeiro::where('saldo_inicial', 0)
            ->whereBetween('vencimento', [$ultimoDiaPeriodoInicial->toDateString(), $dataLimite])
            ->whereNull('lote')
            ->orderBy('vencimento', 'desc')
            ->first()
        )
            ? $ultimoVencimento = Carbon::parse($qUltimoVencimento->getOriginal('vencimento'))
            : $ultimoVencimento = Carbon::today();
        ($qUltimoPagamento = Financeiro::where('saldo_inicial', 0)
            ->whereBetween('pagamento', [$ultimoDiaPeriodoInicial->toDateString(), $dataLimite])
            ->whereNull('lote')
            ->orderBy('pagamento', 'desc')
            ->first()
        )
            ? $ultimoPagamento = Carbon::parse($qUltimoPagamento->getOriginal('pagamento'))
            : $ultimoPagamento = Carbon::today();
        $periodoFinal = $ultimoVencimento->maximum($ultimoPagamento)->firstOfMonth();

        # 3
        $periodos = [];
        while ($periodoInicial->lessThanOrEqualTo($periodoFinal)) {
            $periodos[] = $periodoInicial->firstOfMonth()->toDateString();
            $periodoInicial->addMonth();
        }
        // Prepara as datas inicial e final dos períodos para consulta de lançamentos
        foreach ($periodos as $key => $periodo) {
            $ultimoDiaPeriodo = Carbon::parse($periodo)->lastOfMonth()->toDateString();
            $obj = new StdClass;
            $obj->inicial = $periodo;
            $obj->final = $ultimoDiaPeriodo;
            $periodos[$key] = $obj;
        }

        # 4
        $dados = [];
        foreach ($periodos as $key => $data) {
            
            if ($key == 0) {
                // "Pula" os cálculos se for o mês inicial, correspondente ao saldo inicial.
                $dados[$key] = [
                    'conta_id' => $conta->id,
                    'periodo' => $data->inicial,
                    'saldo' => $valorSaldoInicial,
                    'previsao' => $valorPrevisaoInicial,
                ];
                self::registraSaldo($dados[$key]);
                continue;
            }

            # SALDO ACUMULADO
            $saldoEntradas = DB::table('financeiro')
                ->where('saldo_inicial', 0)
                ->whereIn('genero', ['receber', 'receber-adm'])
                ->where('conta_id', $conta->id)
                ->whereNull('lote')
                ->whereNotNull('tipo_lancamento')
                ->whereBetween('pagamento', [$data->inicial, $data->final])
                ->sum('valor');
            $saldoSaidas = DB::table('financeiro')
                ->where('saldo_inicial', 0)
                ->whereIn('genero', ['pagar'])
                ->where('conta_id', $conta->id)
                ->whereNull('lote')
                ->whereBetween('pagamento', [$data->inicial, $data->final])
                ->sum('valor');
            $saldo = $valorSaldoInicial + ((float) $saldoEntradas - (float) $saldoSaidas);

            # PREVISÃO
            $previsaoEntradas = DB::table('financeiro')
                ->where('saldo_inicial', 0)
                ->whereIn('genero', ['receber', 'receber-adm'])
                ->where('conta_id', $conta->id)
                ->whereNull('lote')
                ->whereNotNull('tipo_lancamento')
                ->where(function($query) use ($data) {
                    $query
                        ->whereBetween('vencimento', [$data->inicial, $data->final])
                        ->orWhereBetween('pagamento', [$data->inicial, $data->final]);
                })
                ->sum('valor');
            $previsaoSaidas = DB::table('financeiro')
                ->where('saldo_inicial', 0)
                ->whereIn('genero', ['pagar'])
                ->where('conta_id', $conta->id)
                ->whereNull('lote')
                ->where(function($query) use ($data) {
                    $query
                        ->whereBetween('vencimento', [$data->inicial, $data->final])
                        ->orWhereBetween('pagamento', [$data->inicial, $data->final]);
                })
                ->sum('valor');
            $previsao = $valorPrevisaoInicial + ((float) $previsaoEntradas - (float) $previsaoSaidas);

            $dados[$key] = [
                'conta_id' => $conta->id,
                'periodo' => $data->inicial,
                'saldo' => $saldo,
                'previsao' => $previsao,
            ];
            self::registraSaldo($dados[$key]);

            $valorSaldoInicial = $saldo;
            $valorPrevisaoInicial = $previsao;
        }

        return $dados;
    }

    public static function registraSaldo($dados)
    {   
        $saldo = self::where('periodo', $dados['periodo'])
            ->where('conta_id', $dados['conta_id'])
            ->first();
        if ($saldo) {
            $saldo->update($dados);
        } else {
            $saldo = self::create($dados);
        }
        return $saldo;
    }

    public static function demonstrativoDiario($mes, $ano)
    {
        $inicio = date($ano.'-'.$mes.'-01');
        $fim = Carbon::parse($inicio)->lastOfMonth()->toDateString(); 
        $contas = $geral = [];

        $saldos = self::with('conta')
            ->select(
                'conta_id', 
                DB::raw("DATE_FORMAT(`periodo`,'%d/%m/%Y') AS periodo"), 
                'saldo'
            )
            ->whereBetween('periodo', [$inicio, $fim])
            ->orderBy('periodo')
            ->get();

        foreach ($saldos as $item) {
            // Geral
            $geral[$item->periodo]['saldo'][] = $item->saldo;
            // Conta
            $contas[$item->conta_id]['nome'] = $item->conta->nome;
            $contas[$item->conta_id]['dados'][$item->periodo]['periodo'] = $item->periodo;
            $contas[$item->conta_id]['dados'][$item->periodo]['saldo'] = $item->saldo;
        }
        foreach ($geral as $periodo => $item) {
            $geral[$periodo]['periodo'] = $periodo;
            $geral[$periodo]['saldo'] = (float) array_sum($item['saldo']);
        }
        return [
            'geral' => $geral,
            'contas' => $contas,
        ];
    }

    public static function demonstrativoMensal($ano)
    {
        $inicio = date($ano.'-01-01');
        $fim = date($ano.'-12-31');
        $geral = $contas = [];

        $saldos = self::with('conta')
            ->join(DB::raw("(SELECT MAX(periodo) AS maxdate FROM saldo GROUP BY YEAR(periodo), MONTH(periodo)) AS x"), 'saldo.periodo', '=', 'maxdate')
            ->select(
                'conta_id', 
                DB::raw("DATE_FORMAT(`periodo`,'%m/%Y') AS periodo"), 
                'saldo'
            )
            ->orderBy('periodo')
            ->get();
        
        foreach ($saldos as $item) {
            // Geral
            $geral[$item->periodo]['saldo'][] = $item->saldo;
            // Contas
            $contas[$item->conta_id]['nome'] = $item->conta->nome;
            $contas[$item->conta_id]['dados'][$item->periodo]['periodo'] = $item->periodo;
            $contas[$item->conta_id]['dados'][$item->periodo]['saldo'] = $item->saldo;
        }
        foreach ($geral as $periodo => $item) {
            $geral[$periodo]['periodo'] = $periodo;
            $geral[$periodo]['saldo'] = (float) array_sum($item['saldo']);
        }

        return [
            'geral' => $geral,
            'contas' => $contas,
        ];
    }

    public static function opcoesMensal() 
    {
        $query = DB::table('saldo')
            ->distinct()
            ->select(
                DB::raw("DATE_FORMAT(`periodo`,'%m/%Y') AS periodo"),
                DB::raw("(CASE WHEN YEAR(periodo) = YEAR(CURDATE()) AND MONTH(periodo) = MONTH(CURDATE()) THEN '1' ELSE '0' END) AS atual")
            )
            ->get();
        $atual = null;
        $periodos = [];
        foreach ($query as $item) {
            if (is_null($atual)) {
                if ($item->atual == 1) {
                    $atual = $item->periodo;
                }
            }
            $periodos[$item->periodo] = $item->periodo;
        }
        if (empty(Session::get('filtro_saldo.periodo_meses'))) {
            Session::put('filtro_saldo.periodo_meses', $atual);
        }
        return $periodos;
    }

    public static function opcoesAnual() 
    {
        $query = DB::table('saldo')
            ->distinct()
            ->select(
                DB::raw("YEAR(periodo) AS periodo"),
                DB::raw("(CASE WHEN YEAR(periodo) = YEAR(CURDATE()) THEN '1' ELSE '0' END) AS atual")
            )
            ->get();
        $atual = null;
        $periodos = [];
        foreach ($query as $item) {
            if (is_null($atual)) {
                if ($item->atual == 1) {
                    $atual = $item->periodo;
                }
            }
            $periodos[$item->periodo] = $item->periodo;
        }
        if (empty(Session::get('filtro_saldo.periodo_anos'))) {
            Session::put('filtro_saldo.periodo_anos', $atual);
        }
        return $periodos;
    }
}
