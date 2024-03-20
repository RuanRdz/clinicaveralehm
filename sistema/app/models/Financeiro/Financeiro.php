<?php

use Carbon\Carbon;

class Financeiro extends \Eloquent
{
    use SoftDeletingTrait;

    protected $table = 'financeiro';
    protected $dates = array('deleted_at');

    protected $fillable = array(
        'tipo',
        'fornecedor_id', 'tratamento_id', 'documento_id',
        'formapagamento_id', 'conta_id', 'centrocusto_id', 'tipodespesa_id', 
        'codigo', 'nota_fiscal', 'descricao', 'parcela',
        'emissao', 'vencimento', 'pagamento',
        'desconto_taxa', 'juros_multa', 'valor', 'valor_pago', 
        'observacao', 'genero', 'cidade_id',
        'tipo_lancamento', 'lote', 'data_conciliacao'
    );

    public static $rulesReceber = array(
        'emissao' => 'required',
        'vencimento' => 'required',
        'valor' => 'required',
        'tratamento_id' => 'required',
        'conta_id' => 'required',
    );
    public static $rulesReceberAdm = array(
        'emissao' => 'required',
        'vencimento' => 'required',
        'valor' => 'required',
        'conta_id' => 'required',
        'centrocusto_id' => 'required',
        'fornecedor_id' => 'required',
    );
    public static $rulesPagar = array(
        'emissao' => 'required',
        'vencimento' => 'required',
        'valor' => 'required',
        'conta_id' => 'required',
        'centrocusto_id' => 'required',
        'fornecedor_id' => 'required',
        'tipodespesa_id' => 'required',
    );
    public static $rulesTransferenciaContas = array(
        'origem_conta_id' => 'required',
        'destino_conta_id' => 'required',
        'data_transferencia' => 'required',
        'valor' => 'required',
    );

    public static $periodosParcelamento = array(
        'semanal'    => 'Semanal',
        'mensal'     => 'Mensal',
        'bimestral'  => 'Bimestral',
        'trimestral' => 'Trimestral',
        'semestral'  => 'Semestral',
        'anual'      => 'Anual',
    );

    public function tratamento()
    {
        return $this->belongsTo('Tratamento')->withTrashed();
    }
    public function fornecedor()
    {
        return $this->belongsTo('Fornecedor')->withTrashed();
    }
    public function formapagamento()
    {
        return $this->belongsTo('Formapagamento')->withTrashed();
    }
    public function documento()
    {
        return $this->belongsTo('Documento')->withTrashed();
    }
    public function conta()
    {
        return $this->belongsTo('Conta')->withTrashed();
    }
    public function centrocusto()
    {
        return $this->belongsTo('Centrocusto')->withTrashed();
    }
    public function tipodespesa()
    {
        return $this->belongsTo('Tipodespesa')->withTrashed();
    }
    public function cidade()
    {
        return $this->belongsTo('Cidade')->withTrashed();
    }

    public function getEmissaoAttribute($value)
    {
        return timestampToBr($value);
    }
    public function getVencimentoAttribute($value)
    {
        return timestampToBr($value);
    }
    public function getPagamentoAttribute($value)
    {
        return timestampToBr($value);
    }
    public function getDataConciliacaoAttribute($value)
    {
        return timestampToBr($value);
    }
    public function getValorAttribute($value)
    {
        return valorBr($value);
    }
    public function getDescontoTaxaAttribute($value)
    {
        return valorBr($value);
    }
    public function getJurosMultaAttribute($value)
    {
        return valorBr($value);
    }
    public function getValorPagoAttribute($value)
    {
        return valorBr($value);
    }

    public function setDescricaoAttribute($value)
    {
        $this->attributes['descricao'] = trim(mb_strtoupper($value, 'UTF-8'));
    }
    public function setEmissaoAttribute($value)
    {
        if ($value == '0' || $value == '0000-00-00' || empty($value)) {
            $value = null;
        }
        $this->attributes['emissao'] = brDateToDatabase($value);
    }
    public function setVencimentoAttribute($value)
    {
        if ($value == '0' || $value == '0000-00-00' || empty($value)) {
            $value = null;
        }
        $this->attributes['vencimento'] = brDateToDatabase($value);
    }
    public function setPagamentoAttribute($value)
    {
        if ($value == '0' || $value == '0000-00-00' || empty($value)) {
            $value = null;
        }
        $this->attributes['pagamento'] = brDateToDatabase($value);
    }
    public function setTratamentoIdAttribute($value)
    {
        $this->attributes['tratamento_id'] = empty(trim($value)) ? null : $value;
    }
    public function setFornecedorIdAttribute($value)
    {
        $this->attributes['fornecedor_id'] = empty(trim($value)) ? null : $value;
    }
    public function setFormapagamentoIdAttribute($value)
    {
        $this->attributes['formapagamento_id'] = empty(trim($value)) ? null : $value;
    }
    public function setDocumentoIdAttribute($value)
    {
        $this->attributes['documento_id'] = empty(trim($value)) ? null : $value;
    }
    public function setContaIdAttribute($value)
    {
        $this->attributes['conta_id'] = empty(trim($value)) ? null : $value;
    }
    public function setCentrocustoIdAttribute($value)
    {
        $this->attributes['centrocusto_id'] = empty(trim($value)) ? null : $value;
    }
    public function setTipodespesaIdAttribute($value)
    {
        $this->attributes['tipodespesa_id'] = empty(trim($value)) ? null : $value;
    }
    public function setCidadeIdAttribute($value)
    {
        $this->attributes['cidade_id'] = empty(trim($value)) ? null : $value;
    }
    public function setValorAttribute($value)
    {
        $this->attributes['valor'] = valorFloat($value);
    }
    public function setDescontoTaxaAttribute($value)
    {
        $this->attributes['desconto_taxa'] = valorFloat($value);
    }
    public function setJurosMultaAttribute($value)
    {
        $this->attributes['juros_multa'] = valorFloat($value);
    }
    public function setValorPagoAttribute($value)
    {
        $this->attributes['valor_pago'] = valorFloat($value);
    }

    // SCOPES
    public function scopetipo($query, $tipos = [])
    {
        return empty($tipos) ? $query : $query->whereIn('tipo', $tipos);
    }
    public function scopeperiodocompleto($query, $datas = null)
    {
        if (empty($datas[0]) || empty($datas[1])) {
            // Sem data selecionada, busca tudo
            return $query;
        }
        return $query->where(function($q) use ($datas) {
            // Não usar emissão
            // $q->whereBetween('emissao', [brDateToDatabase($datas[0]), brDateToDatabase($datas[1])]);
            $q->orWhereBetween('vencimento', [brDateToDatabase($datas[0]), brDateToDatabase($datas[1])]);
            $q->orWhereBetween('pagamento', [brDateToDatabase($datas[0]), brDateToDatabase($datas[1])]);
        });
    }
    public function scopeperiodo($query, $datas = null, $tipodata)
    {
        if (empty($datas[0]) || empty($datas[1])) {
            $datas = array(
                # Dia
                date('Y-m-d'),
                date('Y-m-d'),
                # Mês
                // date('Y-m-01'),
                // date('Y-m-d', strtotime('last day of this month', time())),
            );
        }
        return $query->whereBetween($tipodata, [brDateToDatabase($datas[0]), brDateToDatabase($datas[1])]);
    }
    public function scopegenero($query, $generos = [])
    {
        return empty($generos) ? $query : $query->whereIn('genero', $generos);
    }
    public function scopelancamento($query, $lancamento)
    {
        if (empty($lancamento)) {
            return $query;
        }
        switch ($lancamento) {
            case 'comum': 
                $query
                    ->where('tipo_lancamento', 'individual')
                    ->whereIn('genero', ['receber-adm', 'pagar']);
                break;
            case 'transferencia': 
                $query
                    ->where('tipo_lancamento', 'transferencia')
                    ->whereIn('genero', ['receber-adm', 'pagar']);
                break;
            case 'individual_paciente': 
                $query
                    ->where('tipo_lancamento', 'individual')
                    ->whereIn('genero', ['receber']);
                break;
            case 'lote_paciente': 
                $query
                    ->where('tipo_lancamento', 'lote')
                    ->whereIn('genero', ['receber-adm']);
                break;
        }
        return $query;
    }
    public function scopefornecedor($query, $id)
    {
        return empty($id) ? $query : $query->where('fornecedor_id', $id);
    }
    public function scopeconvenio($query, $id)
    {
        if (!empty($id)) {
            return $query->whereHas('tratamento', function ($q) use ($id) {
                $q->whereIn('tratamentos.convenio_id', $id);
            });
        }
        return $query;
    }
    public function scopeconveniotipo($query, $id)
    {
        if (!empty($id)) {
            $query
                ->join('tratamentos', 'financeiro.tratamento_id', '=', 'tratamentos.id')
                ->join('convenios', 'tratamentos.convenio_id', '=', 'convenios.id')
                ->join('conveniotipos', 'convenios.conveniotipo_id', '=', 'conveniotipos.id')
                ->whereHas('tratamento', function ($query) use ($id) {
                    $query->whereHas('convenio', function ($query) use ($id) {
                        $query->whereIn('convenios.conveniotipo_id', $id);
                    });
                });
        }
        return $query;
    }
    public function scopecentrocusto($query, $id)
    {
        return empty($id) ? $query : $query->whereIn('centrocusto_id', $id);
    }
    public function scopedocumento($query, $id)
    {
        return empty($id) ? $query : $query->whereIn('documento_id', $id);
    }
    public function scopeformapagamento($query, $id)
    {
        return empty($id) ? $query : $query->whereIn('formapagamento_id', $id);
    }
    public function scopeconta($query, $id)
    {
        return empty($id) ? $query : $query->whereIn('conta_id', $id);
    }
    public function scopetipodespesa($query, $id)
    {
        return empty($id) ? $query : $query->whereIn('tipodespesa_id', $id);
    }
    public function scopecidade($query, $id)
    {
        return empty($id) ? $query : $query->whereIn('cidade_id', $id);
    }
    public function scopebusca($query, $keyword)
    {
        if (empty($keyword)) {
            return $query;
        }
        return $query->where(function($q) use ($keyword) {
            $q
                ->where('id', 'LIKE', "%$keyword%")
                ->orWhere('tratamento_id', 'LIKE', "%$keyword%")
                ->orWhere('codigo', 'LIKE', "%$keyword%")
                ->orWhere('nota_fiscal', 'LIKE', "%$keyword%")
                ->orWhere('lote', 'LIKE', "%$keyword%")
                ->orWhere('descricao', 'LIKE', "%$keyword%")
                ->orWhere('observacao', 'LIKE', "%$keyword%");
        });
    }
    public function scopesituacao($query, $situacao)
    {
        // Nenhum selecionado ou todos selecionados, não filtra
        if (
            empty($situacao) || 
            (
                in_array('aberto', $situacao) 
                && in_array('pago', $situacao) 
                && in_array('vencido', $situacao)
            )
        ) {
            return $query;
        }

        // Se foi selecionado 1 item
        if (count($situacao) == 1) {
            switch ($situacao[0]) {
                case 'aberto':
                    return $query
                        ->whereNull('pagamento')
                        ->where('vencimento', '>=', date('Y-m-d'));
                case 'pago':
                    return $query
                        ->whereNotNull('pagamento');
                case 'vencido':
                    return $query
                        ->whereNull('pagamento')
                        ->where('vencimento', '<', date('Y-m-d'));
                default:
                    return $query;
            }
        }

        if (in_array('aberto', $situacao) && in_array('vencido', $situacao)) { // ok
            return $query
                // Abertos ou Vencidos (Qualquer coisa que estiver sem pagamento)
                ->whereNull('pagamento');
        }

        if (in_array('aberto', $situacao) && in_array('pago', $situacao)) {
            return $query
                ->where(function($qq) {
                    $qq
                        ->where(function($q) {
                            $q->where('vencimento', '>=', date('Y-m-d'));
                            $q->whereNull('pagamento');
                        })
                        ->orWhereNotNull('pagamento');
                });                
        }
        
        if (in_array('pago', $situacao) && in_array('vencido', $situacao)) {
            return $query
                ->where(function($qq) {
                    $qq
                        ->where(function($q) {
                            $q->where('vencimento', '<', date('Y-m-d'));
                            $q->whereNull('pagamento');
                        })
                        ->orWhereNotNull('pagamento');
                });  
        }
    }
    public function scopepaciente($query, $paciente)
    {
        if (empty($paciente)) {
            return $query;
        }
        return $query
            ->join('tratamentos', 'financeiro.tratamento_id', '=', 'tratamentos.id')
            ->join('pacientes', 'tratamentos.paciente_id', '=', 'pacientes.id')
            ->where('pacientes.id', '=', $paciente);
    }
    public function scopeterapeuta($query, $terapeuta_id)
    {
        if (empty($terapeuta_id)) {
            return $query;
        }
        return $query
            ->join('tratamentos AS tt', 'financeiro.tratamento_id', '=', 'tt.id')
            // ->join('pacientes', 'tratamentos.paciente_id', '=', 'pacientes.id')
            ->whereIn('tt.terapeuta_id', $terapeuta_id);
    }
    public function scopesomarCreditosMes($query, $datas, $tipodata)
    {
        return $query
            ->where(function ($query) use ($datas, $tipodata) {
                $query->whereBetween(
                    $tipodata, array(
                        brDateToDatabase($datas[0]),
                        brDateToDatabase($datas[1]),
                    )
                );
            })
            ->where('genero', '!=', 'pagar');
    }
    public function scopesomarDebitosMes($query, $datas, $tipodata)
    {
        return $query
            ->where(function ($query) use ($datas, $tipodata) {
                $query->whereBetween(
                    $tipodata, array(
                        brDateToDatabase($datas[0]),
                        brDateToDatabase($datas[1]),
                    )
                );
            })
            ->where('genero', '=', 'pagar');
    }

    // DADOS

    public static function dados($tela)
    {
        $order_by_data = 'vencimento';

        switch ($tela) {

            case 'movimentacao':

                $generos = [];
                if (Session::get('filtro_financeiro.tipomovimentacao_entradas') == 1) {
                    $generos[] = 'receber';
                    $generos[] = 'receber-adm';
                }
                if (Session::get('filtro_financeiro.tipomovimentacao_saidas') == 1) {
                    $generos[] = 'pagar';
                }

                $with = array(
                    'tratamento',
                    'tratamento.paciente',
                    'tratamento.convenio',
                    'tratamento.terapeuta',
                    'fornecedor',
                    'centrocusto',
                    'conta',
                    'documento',
                    'formapagamento',
                    'tipodespesa'
                );

                DB::enableQueryLog();
                return self::with($with)
                    ->genero($generos)
                    ->where('tipo_lancamento', '!=', '')
                    ->periodocompleto(
                        array(
                            Session::get('filtro_financeiro.data_inicial'),
                            Session::get('filtro_financeiro.data_final'),
                        )
                    )
                    ->tipo(Session::get('filtro_financeiro.tipo'))
                    ->lancamento(Session::get('filtro_financeiro.lancamento'))
                    ->situacao(Session::get('filtro_financeiro.situacao'))
                    ->conta(Session::get('filtro_financeiro.conta_id'))
                    ->centrocusto(Session::get('filtro_financeiro.centrocusto_id'))
                    ->tipodespesa(Session::get('filtro_financeiro.tipodespesa_id'))
                    ->documento(Session::get('filtro_financeiro.documento_id'))
                    ->formapagamento(Session::get('filtro_financeiro.formapagamento_id'))
                    ->fornecedor(Session::get('filtro_financeiro.fornecedor_id'))
                    ->cidade(Session::get('filtro_financeiro.cidade_id'))
                    ->busca(Session::get('filtro_financeiro.busca'))
                    ->orderBy($order_by_data)
                    ->orderBy('valor', 'desc');
                break;
            
            case 'receber': // [ Faturamento Pacientes ]

                $with = array(
                    'conta',
                    'documento',
                    'formapagamento', 
                    'tratamento', 
                    'tratamento.convenio',
                    'tratamento.terapeuta',
                    'tratamento.paciente',
                );

                return self::with($with)
                    ->select(
                        'financeiro.*',
                        DB::raw("(SELECT data_sessao FROM agendas WHERE financeiro.tratamento_id = agendas.tratamento_id ORDER BY sessao ASC LIMIT 1) AS data_primeira_sessao"),
                        DB::raw("(SELECT data_sessao FROM agendas WHERE financeiro.tratamento_id = agendas.tratamento_id ORDER BY sessao DESC LIMIT 1) AS data_ultima_sessao")
                    )
                    ->where('genero', '=', 'receber')
                    ->periodocompleto(
                        array(
                            Session::get('filtro_financeiro.data_inicial'),
                            Session::get('filtro_financeiro.data_final'),
                        )
                    )
                    ->tipo(Session::get('filtro_financeiro.tipo'))
                    ->situacao(Session::get('filtro_financeiro.situacao'))
                    ->convenio(Session::get('filtro_financeiro.convenio_id'))
                    ->conveniotipo(Session::get('filtro_financeiro.conveniotipo_id'))
                    ->conta(Session::get('filtro_financeiro.conta_id'))
                    ->documento(Session::get('filtro_financeiro.documento_id'))
                    ->formapagamento(Session::get('filtro_financeiro.formapagamento_id'))
                    ->paciente(Session::get('filtro_financeiro.paciente_id'))
                    ->terapeuta(Session::get('filtro_financeiro.terapeuta_id'))
                    ->busca(Session::get('filtro_financeiro.busca'))
                    ->orderBy($order_by_data, 'asc')
                    ->orderBy('valor', 'desc');
                break;

            case 'contabilidade':

                $generos = [];
                if (Session::get('filtro_financeiro.tipomovimentacao_entradas') == 1) {
                    $generos[] = 'receber';
                    $generos[] = 'receber-adm';
                }
                if (Session::get('filtro_financeiro.tipomovimentacao_saidas') == 1) {
                    $generos[] = 'pagar';
                }

                $with = array(
                    'tratamento',
                    'tratamento.paciente',
                    'tratamento.convenio',
                    'tratamento.terapeuta',
                    'fornecedor',
                    'centrocusto',
                    'conta',
                    'documento',
                    'formapagamento',
                    'tipodespesa'
                );

                return self::with($with)
                    ->genero($generos)
                    ->periodocompleto(
                        array(
                            Session::get('filtro_financeiro.data_inicial'),
                            Session::get('filtro_financeiro.data_final'),
                        )
                    )
                    ->tipo(Session::get('filtro_financeiro.tipo'))
                    // ->lancamento(['comum', 'individual_paciente']) // fixo para contabilidade
                    // ->situacao(Session::get('filtro_financeiro.situacao'))
                    // ->conta(Session::get('filtro_financeiro.conta_id'))
                    // ->centrocusto(Session::get('filtro_financeiro.centrocusto_id'))
                    // ->tipodespesa(Session::get('filtro_financeiro.tipodespesa_id'))
                    // ->documento(Session::get('filtro_financeiro.documento_id'))
                    // ->formapagamento(Session::get('filtro_financeiro.formapagamento_id'))
                    // ->fornecedor(Session::get('filtro_financeiro.fornecedor_id'))
                    // ->cidade(Session::get('filtro_financeiro.cidade_id'))
                    // ->busca(Session::get('filtro_financeiro.busca'))
                    ->orderBy($order_by_data, 'asc')
                    ->orderBy('valor', 'desc');
                break;
        }
    }

    public static function producao($params)
    {
        $profissional_id = $params['profissional'];
        $data_inicial = '01-'.$params['mes'].'-'.$params['ano'];
        $data_final = '31-'.$params['mes'].'-'.$params['ano'];
        $comissao = $params['comissao'];

        $profissional = User::findOrFail($profissional_id);

        $with = array(
            'conta',
            'documento',
            'formapagamento', 
            'tratamento', 
            'tratamento.convenio',
            'tratamento.terapeuta',
            'tratamento.paciente',
        );

        $comissao = !empty($comissao) ? $comissao : 0;

        $dados = self::select(
                'financeiro.*',
                DB::raw("financeiro.valor_pago * $comissao AS valor_comissao")
            )
            ->whereIn('genero', ['receber'])
            // ->whereIn('tipo_lancamento', ['individual', 'lote'])
            // ->where('tipo_lancamento', '=', 'lote')
            ->periodo(
                array(
                    $data_inicial,
                    $data_final,
                ),
                'pagamento'
            )
            ->terapeuta([$profissional->id])
            ->orderBy('pagamento', 'asc')
            ->orderBy('valor', 'desc')
            ->get();

        $resultado = [
            't_valor' => 0,
            't_valor_pago' => 0,
            't_valor_comissao' => 0,
            'dados' => []
        ];

        foreach ($dados as $row) {
            if (empty($row->lote)) { // somente particulares
                $resultado['t_valor'] = $resultado['t_valor'] + valorFloat($row->valor);
                $resultado['t_valor_pago'] = $resultado['t_valor_pago'] + valorFloat($row->valor_pago);
                $resultado['t_valor_comissao'] = $resultado['t_valor_comissao'] + $row->valor_comissao;
                $resultado['dados'][] = $row;
            }
        }
        $resultado['t_valor'] = valorBr($resultado['t_valor']);
        $resultado['t_valor_pago'] = valorBr($resultado['t_valor_pago']);
        $resultado['t_valor_comissao'] = valorBr($resultado['t_valor_comissao']);

        return $resultado;
    }

    public static function movimentacao()
    {
        $dados = self::dados('movimentacao')->get();
        $result = array('dados' => array(), 'total' => array());
        $credito = $debito = [];
        $index = 0;

        foreach ($dados as $row) {

            $favorecido = $descricao = $conta = $centro_custo = $forma_pagamento = $documento = $tipo_despesa = '';
            $tipo_movimento = $border_color = $text_color = $bg_row = $icone = $icone_status = $label_tipo_lancamento = '';
            $route_editar = $route_recibo = $route_duplicar = $route_excluir = $route_listar_lote = ''; 
            $valor = $valor_pago = 0;

            if (!empty($row->conta)) { $conta = $row->conta->nome; }
            if (!empty($row->centrocusto)) { $centro_custo = $row->centrocusto->nome; }
            if (!empty($row->formapagamento)) { $forma_pagamento = $row->formapagamento->nome; }
            if (!empty($row->documento)) { $documento = $row->documento->nome; }
            if (!empty($row->tipodespesa)) { $tipo_despesa = $row->tipodespesa->nome; }

            $parcela = $row->parcela ? $row->parcela : 1;

            switch($row->genero) :
                case 'receber':
                    $valor = $row->getOriginal('valor');
                    $valor_pago = $row->getOriginal('valor_pago');
                    $credito[] = $valor_pago;
                    $tipo_movimento = 'ENTRADA';
                    $favorecido = $row->tratamento ? $row->tratamento->paciente->nome : '';
                    $descricao = $row->observacao;
                    $route_editar = route('financeiroEditReceber', ['id' => $row->id]);
                    $route_recibo = route('financeiroGerarRecibo', ['id' => $row->id]);
                    $route_duplicar = route('financeiroDuplicate', ['id' => $row->id]); 
                    $route_excluir = route('financeiroDestroy', ['id' => $row->id]);
                    $route_listar_lote = route('financeiroListarItensLote', ['id' => $row->id]);
                    $border_color = 'border-green-400';
                    $text_color = 'text-green-700';
                    $icone = 'fa fa-user-circle';
                    $label_tipo_lancamento = 'Individual Paciente';
                    break;
                case 'receber-adm':
                    $valor = $row->getOriginal('valor');
                    $valor_pago = $row->getOriginal('valor_pago');
                    $credito[] = $valor_pago;
                    $tipo_movimento = 'ENTRADA';
                    $favorecido = $row->fornecedor ? $row->fornecedor->nome : '';
                    $descricao = $row->descricao;
                    $route_editar = route('financeiroEditReceberAdm', ['id' => $row->id]);
                    $route_recibo = route('financeiroGerarRecibo', ['id' => $row->id]);
                    $route_duplicar = route('financeiroDuplicate', ['id' => $row->id]); 
                    $route_excluir = route('financeiroDestroy', ['id' => $row->id]);
                    $route_listar_lote = route('financeiroListarItensLote', ['id' => $row->id]);
                    $border_color = 'border-green-400';
                    $text_color = 'text-green-700';
                    $icone = 'fa fa-file-text-o';
                    $label_tipo_lancamento = 'Comum';
                    break;
                case 'pagar':
                    $valor = -$row->getOriginal('valor');
                    $valor_pago = -$row->getOriginal('valor_pago');
                    $debito[] = $valor_pago;
                    $tipo_movimento = 'SAÍDA';
                    $favorecido = $row->fornecedor ? $row->fornecedor->nome : '';
                    $descricao = $row->descricao;
                    $route_editar = route('financeiroEditPagar', ['id' => $row->id]);
                    $route_recibo = route('financeiroGerarRecibo', ['id' => $row->id]);
                    $route_duplicar = route('financeiroDuplicate', ['id' => $row->id]); 
                    $route_excluir = route('financeiroDestroy', ['id' => $row->id]);
                    $route_listar_lote = route('financeiroListarItensLote', ['id' => $row->id]);
                    $border_color = 'border-red-400';
                    $text_color = 'text-red-600';
                    $icone = 'fa fa-file-text-o';
                    $label_tipo_lancamento = 'Comum';
                    break;
            endswitch;

            if ($row->pagamento) {
                $icone_status = 'fa fa-fw fa-check';
            } else if (!$row->pagamento && (brDateToDatabase($row->vencimento) < date('Y-m-d'))) {
                $bg_row = 'bg-danger';
                $icone_status = 'fa fa-fw fa-exclamation-triangle';
            } else {
                $bg_row = '';
                $icone_status = 'fa fa-fw fa-clock-o';
            }

            $readonly = false;
            if ($row->saldo_inicial || $row->tipo_lancamento == 'transferencia') {
                $readonly = true;
                if ($row->conta->deleted_at) {
                    continue;
                }
                $text_color = 'text-blue-600';
                $border_color = 'border-blue-400';
                $bg_row = 'bg-blue-200';
                $icone = 'fa fa-star';
                $label_tipo_lancamento = 'Saldo Inicial';
            }

            if ($row->tipo_lancamento == 'lote') {
                $icone = 'fa fa-clone';
                $label_tipo_lancamento = 'Lote Pacientes: '.$row->id;
            }

            if ($row->tipo_lancamento == 'transferencia') {
                $text_color = 'text-purple-600';
                $border_color = 'border-purple-400';
                $bg_row = '';
                switch ($row->genero) {
                    case 'receber-adm': 
                        $icone = 'fa fa-download';
                        $label_tipo_lancamento = 'Transferência (Entrada)';
                        break;
                    case 'pagar': 
                        $icone = 'fa fa-upload';
                        $label_tipo_lancamento = 'Transferência (Saída)';
                        break;
                }
            }

            $result['dados'][$index]['id'] = $row->id;
            $result['dados'][$index]['tipo'] = $row->tipo;
            $result['dados'][$index]['tipo_movimento'] = $tipo_movimento;
            $result['dados'][$index]['genero'] = $row->genero;
            $result['dados'][$index]['lote'] = $row->lote;
            $result['dados'][$index]['tipo_lancamento'] = $row->tipo_lancamento;
            $result['dados'][$index]['label_tipo_lancamento'] = $label_tipo_lancamento; // $row->tipo_lancamento == 'lote' ? $row->id : '';
            $result['dados'][$index]['saldo_inicial'] = $row->saldo_inicial;
            $result['dados'][$index]['favorecido'] = $favorecido;
            $result['dados'][$index]['descricao'] = trim(mb_strtoupper($descricao, 'UTF-8'));
            $result['dados'][$index]['conta'] = trim(mb_strtoupper($conta, 'UTF-8'));
            $result['dados'][$index]['centro_custo'] = trim(mb_strtoupper($centro_custo, 'UTF-8'));
            $result['dados'][$index]['forma_pagamento'] = trim(mb_strtoupper($forma_pagamento, 'UTF-8'));
            $result['dados'][$index]['tipo_despesa'] = trim(mb_strtoupper($tipo_despesa, 'UTF-8'));
            $result['dados'][$index]['documento'] = trim(mb_strtoupper($documento, 'UTF-8'));
            $result['dados'][$index]['codigo'] = $row->codigo;
            $result['dados'][$index]['nota_fiscal'] = $row->nota_fiscal;
            $result['dados'][$index]['parcela'] = $parcela;
            $result['dados'][$index]['emissao'] = $row->emissao;
            $result['dados'][$index]['vencimento'] = $row->vencimento;
            $result['dados'][$index]['pagamento'] = $row->pagamento;
            $result['dados'][$index]['desconto_taxa'] = $row->desconto_taxa;
            $result['dados'][$index]['juros_multa'] = $row->juros_multa;
            $result['dados'][$index]['valor'] = valorBr($valor);
            $result['dados'][$index]['valor_pago'] = valorBr($valor_pago);
            $result['dados'][$index]['data_conciliacao'] = $row->data_conciliacao;
            $result['dados'][$index]['readonly'] = $readonly;
            $result['dados'][$index]['route_editar'] = $route_editar;
            $result['dados'][$index]['route_recibo'] = $route_recibo;
            $result['dados'][$index]['route_duplicar'] = $route_duplicar;
            $result['dados'][$index]['route_excluir'] = $route_excluir;
            $result['dados'][$index]['route_listar_lote'] = $route_listar_lote;
            $result['dados'][$index]['text_color'] = $text_color;
            $result['dados'][$index]['border_color'] = $border_color;
            $result['dados'][$index]['bg_row'] = $bg_row;
            $result['dados'][$index]['icone'] = $icone;
            $result['dados'][$index]['icone_status'] = $icone_status;
            $index++;
        }

        $totalCredito = array_sum($credito);
        $totalDebito = array_sum($debito);
        $totalSaldo = $totalCredito + $totalDebito;
        $result['total']['credito'] = valorBr($totalCredito);
        $result['total']['debito'] = valorBr($totalDebito);
        $result['total']['saldo'] = valorBr($totalSaldo);

        return $result;
    }

    public static function contabilidade()
    {
        $dados = self::dados('contabilidade')->get();

        $result = array('dados' => array(), 'total' => array());
        $credito = $debito = [];

        foreach ($dados as $row) {

            if ($row->tipo_lancamento == 'lote') {
                continue;
            }

            $favorecido = $identificacao = $descricao = $conta = $centro_custo = $forma_pagamento = $documento = $tipo_despesa = '';
            $tipo_movimento = $valor = $valor_pago = 0;

            if (!empty($row->conta)) { $conta = $row->conta->nome; }
            if (!empty($row->centrocusto)) { $centro_custo = $row->centrocusto->nome; }
            if (!empty($row->formapagamento)) { $forma_pagamento = $row->formapagamento->nome; }
            if (!empty($row->documento)) { $documento = $row->documento->nome; }
            if (!empty($row->tipodespesa)) { $tipo_despesa = $row->tipodespesa->nome; }

            $parcela = $row->parcela ? $row->parcela : 1;

            switch($row->genero) :
                case 'receber':
                    $valor = $row->getOriginal('valor');
                    $valor_pago = $row->getOriginal('valor_pago');
                    $credito[] = $valor_pago;
                    $tipo_movimento = 'ENTRADA';
                    $descricao = $row->observacao;
                    if ($row->tratamento) {
                        if ($row->tratamento->paciente) {
                            $favorecido = $row->tratamento->paciente->nome;
                            if ($rg = $row->tratamento->paciente->rg) {
                                $identificacao = 'RG: '.$rg.' ';
                            }
                            if ($cpf = $row->tratamento->paciente->cpf) {
                                $identificacao .= ' CPF: '.$cpf;
                            }
                        }
                    }
                    break;
                case 'receber-adm':
                    $valor = $row->getOriginal('valor');
                    $valor_pago = $row->getOriginal('valor_pago');
                    $credito[] = $valor_pago;
                    $tipo_movimento = 'ENTRADA';
                    $descricao = $row->descricao;
                    if ($row->fornecedor) {
                        $favorecido = $row->fornecedor->nome;
                        if ($cnpj = $row->fornecedor->cnpj) {
                            $identificacao = 'CNPJ: '.$cnpj.' ';
                        }
                        if ($cpf = $row->fornecedor->cpf) {
                            $identificacao .= 'CPF: '.$cpf;
                        }
                    }
                    break;
                case 'pagar':
                    $valor = $row->getOriginal('valor');
                    $valor_pago = $row->getOriginal('valor_pago');
                    $debito[] = $valor_pago;
                    $tipo_movimento = 'SAÍDA';
                    $descricao = $row->descricao;
                    if ($row->fornecedor) {
                        $favorecido = $row->fornecedor->nome;
                        if ($cnpj = $row->fornecedor->cnpj) {
                            $identificacao = 'CNPJ: '.$cnpj.' ';
                        }
                        if ($cpf = $row->fornecedor->cpf) {
                            $identificacao .= 'CPF: '.$cpf;
                        }
                    }
                    break;
            endswitch;

            if ($row->saldo_inicial) {
                if ($row->conta->deleted_at) {
                    continue;
                }
            }

            if ($row->tipo_lancamento == 'transferencia') {
                continue;
            }

            $result['dados'][$row->id]['id'] = $row->id;
            $result['dados'][$row->id]['tipo'] = $row->tipo;
            $result['dados'][$row->id]['tipo_movimento'] = $tipo_movimento;
            $result['dados'][$row->id]['genero'] = $row->genero;
            $result['dados'][$row->id]['lote'] = $row->lote;
            $result['dados'][$row->id]['tipo_lancamento'] = $row->tipo_lancamento;
            $result['dados'][$row->id]['saldo_inicial'] = $row->saldo_inicial;
            $result['dados'][$row->id]['favorecido'] = $favorecido;
            $result['dados'][$row->id]['identificacao'] = trim($identificacao);
            $result['dados'][$row->id]['descricao'] = trim(mb_strtoupper($descricao, 'UTF-8'));
            $result['dados'][$row->id]['conta'] = trim(mb_strtoupper($conta, 'UTF-8'));
            $result['dados'][$row->id]['centro_custo'] = trim(mb_strtoupper($centro_custo, 'UTF-8'));
            $result['dados'][$row->id]['forma_pagamento'] = trim(mb_strtoupper($forma_pagamento, 'UTF-8'));
            $result['dados'][$row->id]['tipo_despesa'] = trim(mb_strtoupper($tipo_despesa, 'UTF-8'));
            $result['dados'][$row->id]['documento'] = trim(mb_strtoupper($documento, 'UTF-8'));
            $result['dados'][$row->id]['codigo'] = $row->codigo;
            $result['dados'][$row->id]['nota_fiscal'] = $row->nota_fiscal;
            $result['dados'][$row->id]['parcela'] = $parcela;
            $result['dados'][$row->id]['emissao'] = $row->emissao;
            $result['dados'][$row->id]['vencimento'] = $row->vencimento;
            $result['dados'][$row->id]['pagamento'] = $row->pagamento;
            $result['dados'][$row->id]['desconto_taxa'] = $row->desconto_taxa;
            $result['dados'][$row->id]['juros_multa'] = $row->juros_multa;
            $result['dados'][$row->id]['valor'] = valorBr($valor);
            $result['dados'][$row->id]['valor_pago'] = valorBr($valor_pago);
            $result['dados'][$row->id]['data_conciliacao'] = $row->data_conciliacao;
        }

        $totalCredito = array_sum($credito);
        $totalDebito = array_sum($debito);
        $totalSaldo = $totalCredito + $totalDebito;
        $result['total']['credito'] = valorBr($totalCredito);
        $result['total']['debito'] = valorBr($totalDebito);
        $result['total']['saldo'] = valorBr($totalSaldo);

        return $result;
    }

    /**
     * $recurso: conta, centrocusto, etc
     * $ano: Y
     */
    public static function fluxoDeCaixa($recurso, $ano)
    {
        $meses_data = ['01','02','03','04','05','06','07','08','09','10','11','12'];
        $meses_nome = ['JAN','FEV','MAR','ABR','MAI','JUN','JUL','AGO','SET','OUT','NOV','DEZ'];
        $result = ['header' => [], 'body' => []];
        $result['header'] = [
            'ano' => $ano,
            'meses_data' => $meses_data,
            'meses_nome' => $meses_nome,
        ];

        switch ($recurso) {
            case 'centrocusto':
                $itens = Centrocusto::orderBy('nome')->get();
                $fk = 'centrocusto_id';
                break;
            case 'documento':
                $itens = Documento::orderBy('nome')->get();
                $fk = 'documento_id';
                break;
            case 'formapagamento':
                $itens = Formapagamento::orderBy('nome')->get();
                $fk = 'formapagamento_id';
                break;
            case 'tipodespesa':
                $itens = Tipodespesa::orderBy('nome')->get();
                $fk = 'tipodespesa_id';
                break;
        }
        
        foreach ($itens as $id => $item) {
            $result['body'][$item->id]['id'] = $item->id;
            $result['body'][$item->id]['nome'] = $item->nome;
            foreach (['entrada', 'saida'] as $tipo) {
                $generos = [];
                if ($tipo == 'entrada') {
                    $generos[] = 'receber';
                    $generos[] = 'receber-adm';
                } else {
                    $generos[] = 'pagar';
                }
                foreach ($meses_data as $mes) {
                    $data_inicial = date($ano.'-'.$mes.'-01');
                    $date = new DateTime($data_inicial);
                    $date->modify('last day of this month');
                    $data_final = $date->format('Y-m-d');
                    $sum = self::where($fk, $item->id)
                        ->genero($generos)
                        ->whereBetween('pagamento', [$data_inicial, $data_final])
                        ->sum('valor');
                    $result['body'][$item->id][$tipo]['valores'][] = (float) $sum;
                }
                // $result['body'][$item->id][$tipo]['total'] = array_sum($result['body'][$item->id][$tipo]['valores']);
            }
        }

        return $result;
    }

    public static function contabilidadeExcel()
    {
        $financeiro = self::contabilidade();

        $objPHPExcel = new PHPExcel();
        $objPHPExcel
            ->getProperties()
            ->setCreator('Clínica Vera Lehm')
            ->setTitle('Movimentação');

        $objPHPExcel->getDefaultStyle()->getFont()->setSize(10);
        
        $objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(13);
        $objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(13);
        $objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(13);
        $objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(13);
        $objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(13);
        $objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(20);
        $objPHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth(13);
        $objPHPExcel->getActiveSheet()->getColumnDimension('H')->setWidth(13);
        $objPHPExcel->getActiveSheet()->getColumnDimension('I')->setWidth(11);
        $objPHPExcel->getActiveSheet()->getColumnDimension('J')->setWidth(12);
        $objPHPExcel->getActiveSheet()->getColumnDimension('K')->setWidth(50);
        $objPHPExcel->getActiveSheet()->getColumnDimension('L')->setWidth(40);
        $objPHPExcel->getActiveSheet()->getColumnDimension('M')->setWidth(50);
        $objPHPExcel->getActiveSheet()->getColumnDimension('N')->setWidth(40);
        $objPHPExcel->getActiveSheet()->getColumnDimension('O')->setWidth(30);
        $objPHPExcel->getActiveSheet()->getColumnDimension('P')->setWidth(40);
        $objPHPExcel->getActiveSheet()->getColumnDimension('Q')->setWidth(40);
        $objPHPExcel->getActiveSheet()->getColumnDimension('R')->setWidth(40);
        $objPHPExcel->getActiveSheet()->getColumnDimension('S')->setWidth(40);
        $objPHPExcel->getActiveSheet()->getColumnDimension('T')->setWidth(40);
        $objPHPExcel->getActiveSheet()->getColumnDimension('U')->setWidth(20);
        $objPHPExcel->getActiveSheet()->getColumnDimension('V')->setWidth(11);
        $objPHPExcel->getActiveSheet()->getColumnDimension('X')->setWidth(12);

        $objPHPExcel
            ->setActiveSheetIndex(0)
            ->setCellValue('A1', 'TIPO')
            ->setCellValue('B1', 'COMPETÊNCIA')
            ->setCellValue('C1', 'VENCIMENTO')
            ->setCellValue('D1', 'PAGAMENTO')
            ->setCellValue('E1', 'VALOR')
            ->setCellValue('F1', 'DESCONTOS/TAXAS')
            ->setCellValue('G1', 'JUROS/MULTA')
            ->setCellValue('H1', 'VALOR PAGO')
            ->setCellValue('I1', 'PARCELA')
            ->setCellValue('J1', 'LOTE')
            ->setCellValue('K1', 'EMISSOR/FAVORECIDO')
            ->setCellValue('L1', 'DOC. IDENTIFICAÇÃO')
            ->setCellValue('M1', 'DESCRIÇÃO')
            ->setCellValue('N1', 'CÓDIGO')
            ->setCellValue('O1', 'NOTA FISCAL')
            ->setCellValue('P1', 'CONTA')
            ->setCellValue('Q1', 'PLANO DE CONTAS')
            ->setCellValue('R1', 'FORMA DE PAGAMENTO')
            ->setCellValue('S1', 'TIPO DOCUMENTO')
            ->setCellValue('T1', 'CENTRO E CUSTOS')
            ->setCellValue('U1', 'DATA CONCILIAÇÃO')
            ->setCellValue('V1', '!TIPO!')
            ->setCellValue('X1', '(ID sistema)');

        $objPHPExcel->getActiveSheet()->getStyle('A1:D1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
        $objPHPExcel->getActiveSheet()->getStyle('E1:H1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
        $objPHPExcel->getActiveSheet()->getStyle('I1:V1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);

        $i = 2;
        foreach($financeiro['dados'] as $row) {
            $objPHPExcel
                ->setActiveSheetIndex(0)
                ->setCellValue('A'.$i, isset($row['tipo_movimento'])?$row['tipo_movimento']:null)
                ->setCellValue('B'.$i, isset($row['emissao'])?$row['emissao']:null)
                ->setCellValue('C'.$i, isset($row['vencimento'])?$row['vencimento']:null)
                ->setCellValue('D'.$i, isset($row['pagamento'])?$row['pagamento']:null)
                ->setCellValue('E'.$i, isset($row['valor'])?$row['valor']:null)
                ->setCellValue('F'.$i, isset($row['desconto_taxa'])?$row['desconto_taxa']:null)
                ->setCellValue('G'.$i, isset($row['juros_multa'])?$row['juros_multa']:null)
                ->setCellValue('H'.$i, isset($row['valor_pago'])?$row['valor_pago']:null)
                ->setCellValue('I'.$i, isset($row['parcela'])?$row['parcela']:null)
                ->setCellValue('J'.$i, isset($row['lote'])?$row['lote']:null)
                ->setCellValue('K'.$i, isset($row['favorecido'])?$row['favorecido']:null)
                ->setCellValue('L'.$i, isset($row['identificacao'])?$row['identificacao']:null)
                ->setCellValue('M'.$i, isset($row['descricao'])?$row['descricao']:null)
                ->setCellValue('N'.$i, isset($row['codigo'])?$row['codigo']:null)
                ->setCellValue('O'.$i, isset($row['nota_fiscal'])?$row['nota_fiscal']:null)
                ->setCellValue('P'.$i, isset($row['conta'])?$row['conta']:null)
                ->setCellValue('Q'.$i, isset($row['centro_custo'])?$row['centro_custo']:null)
                ->setCellValue('R'.$i, isset($row['forma_pagamento'])?$row['forma_pagamento']:null)
                ->setCellValue('S'.$i, isset($row['documento'])?$row['documento']:null)
                ->setCellValue('T'.$i, isset($row['tipo_despesa'])?$row['tipo_despesa']:null)
                ->setCellValue('U'.$i, isset($row['data_conciliacao'])?$row['data_conciliacao']:null)
                ->setCellValue('V'.$i, isset($row['tipo'])?$row['tipo']:null)
                ->setCellValue('X'.$i, isset($row['id'])?$row['id']:null);
            $objPHPExcel->getActiveSheet()->getStyle('A'.$i.':D'.$i)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
            $objPHPExcel->getActiveSheet()->getStyle('E'.$i.':H'.$i)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
            $objPHPExcel->getActiveSheet()->getStyle('I'.$i.':V'.$i)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
            $i++;
        }

        $objPHPExcel->getActiveSheet()->setTitle('Movimentação');

        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="financeiro-movimentacao-'.date('d-m-Y_G-i-s').'.xlsx"');
        header('Cache-Control: max-age=0');
        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
        $objWriter->save('php://output');
    }

    public static function pacientesExcel()
    {
        $financeiro = self::dados('receber')->get();

        $objPHPExcel = new PHPExcel();
        $objPHPExcel
            ->getProperties()
            ->setCreator('Clínica Vera Lehm')
            ->setTitle('Faturamento Pacientes');

        $objPHPExcel->getDefaultStyle()->getFont()->setSize(10);

        $objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(13);
        $objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(13);
        $objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(13);
        $objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(13);
        $objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(20);
        $objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(13);
        $objPHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth(13);
        $objPHPExcel->getActiveSheet()->getColumnDimension('H')->setWidth(10);
        $objPHPExcel->getActiveSheet()->getColumnDimension('I')->setWidth(13);
        $objPHPExcel->getActiveSheet()->getColumnDimension('J')->setWidth(50);
        $objPHPExcel->getActiveSheet()->getColumnDimension('K')->setWidth(50);
        $objPHPExcel->getActiveSheet()->getColumnDimension('L')->setWidth(50);
        $objPHPExcel->getActiveSheet()->getColumnDimension('M')->setWidth(50);
        $objPHPExcel->getActiveSheet()->getColumnDimension('N')->setWidth(40);
        $objPHPExcel->getActiveSheet()->getColumnDimension('O')->setWidth(30);
        $objPHPExcel->getActiveSheet()->getColumnDimension('P')->setWidth(40);
        $objPHPExcel->getActiveSheet()->getColumnDimension('Q')->setWidth(40);
        $objPHPExcel->getActiveSheet()->getColumnDimension('R')->setWidth(40);
        $objPHPExcel->getActiveSheet()->getColumnDimension('S')->setWidth(20);
        $objPHPExcel->getActiveSheet()->getColumnDimension('T')->setWidth(20);
        $objPHPExcel->getActiveSheet()->getColumnDimension('U')->setWidth(20);
        $objPHPExcel->getActiveSheet()->getColumnDimension('V')->setWidth(10);

        $objPHPExcel
            ->setActiveSheetIndex(0)
            ->setCellValue('A1', 'COMPETÊNCIA')
            ->setCellValue('B1', 'VENCIMENTO')
            ->setCellValue('C1', 'PAGAMENTO')
            ->setCellValue('D1', 'VALOR')
            ->setCellValue('E1', 'DESCONTOS/TAXAS')
            ->setCellValue('F1', 'JUROS/MULTA')
            ->setCellValue('G1', 'VALOR PAGO')
            ->setCellValue('H1', 'PARCELA')
            ->setCellValue('I1', 'LOTE')
            ->setCellValue('J1', 'CONVÊNIO')
            ->setCellValue('K1', 'PROFISSIONAL')
            ->setCellValue('L1', 'PACIENTE')
            ->setCellValue('M1', 'OBSERVAÇÃO')
            ->setCellValue('N1', 'CÓDIGO')
            ->setCellValue('O1', 'NOTA FISCAL')
            ->setCellValue('P1', 'CONTA')
            ->setCellValue('Q1', 'FORMA DE PAGAMENTO')
            ->setCellValue('R1', 'DOCUMENTO')
            ->setCellValue('S1', 'DATA TRATAMENTO')
            ->setCellValue('T1', 'PRIMEIRA SESSÃO')
            ->setCellValue('U1', 'ÚLTIMA SESSÃO')
            ->setCellValue('V1', 'ID');

        $objPHPExcel->getActiveSheet()->getStyle('A1:F1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
        $objPHPExcel->getActiveSheet()->getStyle('D1:G1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
        $objPHPExcel->getActiveSheet()->getStyle('H1:V1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);

        $i = 2;
        foreach($financeiro as $row) {
            $objPHPExcel
                ->setActiveSheetIndex(0)
                ->setCellValue('A'.$i, $row->emissao)
                ->setCellValue('B'.$i, $row->vencimento)
                ->setCellValue('C'.$i, $row->pagamento)
                ->setCellValue('D'.$i, $row->valor)
                ->setCellValue('E'.$i, $row->desconto_taxa)
                ->setCellValue('F'.$i, $row->juros_multa)
                ->setCellValue('G'.$i, $row->valor_pago)
                ->setCellValue('H'.$i, $row->parcela)
                ->setCellValue('I'.$i, $row->lote)
                ->setCellValue('J'.$i, isset($row->tratamento->convenio) ? $row->tratamento->convenio->nome : '')
                ->setCellValue('K'.$i, isset($row->tratamento->terapeuta) ? mb_strtoupper($row->tratamento->terapeuta->full_name, 'UTF-8') : '')
                ->setCellValue('L'.$i, isset($row->tratamento->paciente) ? $row->tratamento->paciente->nome : '')
                ->setCellValue('M'.$i, $row->observacao)
                ->setCellValue('N'.$i, $row->codigo)
                ->setCellValue('O'.$i, $row->nota_fiscal)
                ->setCellValue('P'.$i, isset($row->conta) ? $row->conta->nome : '')
                ->setCellValue('Q'.$i, isset($row->formapagamento) ? $row->formapagamento->nome : '')
                ->setCellValue('R'.$i, isset($row->documento) ? $row->documento->nome : '')
                ->setCellValue('S'.$i, isset($row->tratamento) ? $row->tratamento->created_at : '')
                ->setCellValue('T'.$i, timestampToBr($row->data_primeira_sessao))
                ->setCellValue('U'.$i, timestampToBr($row->data_ultima_sessao))
                ->setCellValue('V'.$i, $row->id);

            $objPHPExcel->getActiveSheet()->getStyle('A'.$i.':F'.$i)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
            $objPHPExcel->getActiveSheet()->getStyle('D'.$i.':G'.$i)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
            $objPHPExcel->getActiveSheet()->getStyle('H'.$i.':V'.$i)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
            $i++;
        }

        $objPHPExcel->getActiveSheet()->setTitle('Faturamento Pacientes');

        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="financeiro-recebimentos-pacientes-'.date('d-m-Y_G-i-s').'.xlsx"');
        header('Cache-Control: max-age=0');
        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
        $objWriter->save('php://output');
    }

    public static function fluxoExcel()
    {
        // TODO
    }
    
    public static function formOptions()
    {
        return array(
            'centrocusto' => array('' => '') + Centrocusto::orderBy('nome')->lists('nome', 'id'),
            'fornecedor' => array('' => '') + Fornecedor::orderBy('nome')->lists('nome', 'id'),
            'documento' => array('' => '') + Documento::orderBy('nome')->lists('nome', 'id'),
            'formapagamento' => array('' => '') + Formapagamento::orderBy('nome')->lists('nome', 'id'),
            'conta' => array('' => '') + Conta::orderBy('nome')->lists('nome', 'id'),
            'tipodespesa' => array('' => '') + Tipodespesa::orderBy('nome')->lists('nome', 'id'),
            'cidade' => array('' => '') + Cidade::orderBy('nome')->lists('nome', 'id'),
            'periodosParcelamento' => array('' => '') + Financeiro::$periodosParcelamento,
            'tipo' => array('' => '', 1 => '1', 2 => '2'),
        );
    }

    public static function filtroOptions()
    {
        $tipo = array(
            '' => 'Indefinido', 
            '1' => '1', 
            '2' => '2'
        );
        $tipomovimentacao = array(
            'todos' => 'Todos',
            'entradas' => 'Entradas',
            'saidas' => 'Saídas',
        );
        $lancamento = array(
            '' => '',
            'comum' => 'Comum',
            'individual_paciente' => 'Individual Paciente',
            'lote_paciente' => 'Lote Pacientes',
            'transferencia' => 'Transferência',
        );
        $tipodata = array(
            'vencimento' => 'Vencimento / Previsão',
            'pagamento' => 'Pagamento / Concluído',
            'emissao' => 'Competência / Emissão',
        );
        $situacao = array(
            'aberto' => 'Aberto / Previsão',
            'pago' => 'Pago / Concluído',
            'vencido' => 'Vencido',
        );
        $conta = Conta::orderBy('nome')->lists('nome', 'id');
        $formapagamento = Formapagamento::orderBy('nome')->lists('nome', 'id');
        $documento = Documento::orderBy('nome')->lists('nome', 'id');
        $centrocusto = Centrocusto::orderBy('nome')->lists('nome', 'id');
        $tipodespesa = Tipodespesa::orderBy('nome')->lists('nome', 'id');
        $fornecedor = array('' => ''); // + Fornecedor::orderBy('nome')->lists('nome', 'id'); // SUBSTITUIDO PELO AUTOCOMPLETE
        $paciente = array('' => ''); // + Paciente::orderBy('nome')->lists('nome', 'id'); // SUBSTITUIDO PELO AUTOCOMPLETE
        $conveniotipo = Conveniotipo::orderBy('nome')->lists('nome', 'id');

        $convenio = self::select('convenio_id', 'convenios.nome')
            ->join('tratamentos', 'tratamentos.id', '=', 'tratamento_id')
            ->join('convenios', 'convenios.id', '=', 'tratamentos.convenio_id')
            ->distinct()
            ->orderBy('convenios.nome')
            ->lists('convenios.nome', 'convenio_id');

        $cidade = self::select('cidade_id', 'cidades.nome')
            ->join('cidades', 'cidades.id', '=', 'financeiro.cidade_id')
            ->distinct()
            ->orderBy('cidades.nome')
            ->lists('cidades.nome', 'cidade_id');

        Session::get('workspace_id')
            ? $usuarios = Workspace::terapeutas(Session::get('workspace_id'))->lists('fullName', 'id')
            : $usuarios = [];
        $terapeutas = [];
        foreach ($usuarios as $id => $option) {
            if (
                Auth::user()->credential == 20 && 
                !Auth::user()->isAdmin &&
                $id != Auth::user()->id
            ) {
                continue;
            }
            $terapeutas[$id] = $option;
        }

        return array(
            'tipo' => $tipo,
            'tipomovimentacao' => $tipomovimentacao,
            'lancamento' => $lancamento,
            'fornecedor' => $fornecedor,
            'paciente' => $paciente,
            'convenio' => $convenio,
            'conveniotipo' => $conveniotipo,
            'tipodata' => $tipodata,
            'situacao' => $situacao,
            'centrocusto' => $centrocusto,
            'documento' => $documento,
            'formapagamento' => $formapagamento,
            'conta' => $conta,
            'tipodespesa' => $tipodespesa,
            'cidade' => $cidade,
            'terapeutas' => $terapeutas,
        );
    }

    public function gerarRecibo()
    {
        $s = Sistema::parametros();
        $dia = date('d');
        $mes = Lang::get('months.'.date('F'));
        $ano = date('Y');

        $recibo = [
            'numero' => time(),
            'valor' => $this->valor,
            'data_pagamento' => $this->pagamento,
            'documento' => '',
            'descricao' => '',
            'recebido_de' => '',
            'nome_emitente' => '',
            'data_recibo' => "{$s['cidade']}, $dia de $mes de $ano",
            'rodape' => ''
        ];

        switch ($this->genero) {
            case 'receber':
                $documento = 'CPF nº ';
                $recebido_de = '';
                $descricao = '';
                if (!is_null($this->tratamento)) {
                    $documento .= $this->tratamento->paciente->cpf;
                    $recebido_de = $this->tratamento->paciente->nome;
                    if (!is_null($this->tratamento->convenio)) {
                        $descricao = $this->tratamento->convenio->nome;
                    }
                }
                $recibo['documento'] = $documento;
                $recibo['descricao'] = $descricao;
                $recibo['recebido_de'] = $recebido_de;
                $recibo['nome_emitente'] = $s['razao_social'];
                break; 

            case 'receber-adm':
                $documento = 'nº';
                $recebido_de = '';
                if (!is_null($this->fornecedor)) {
                    $recebido_de = $this->fornecedor->nome;
                    if (!empty($this->fornecedor->cnpj)) {
                        $documento = 'CNPJ nº '.$this->fornecedor->cnpj;
                    } else if ($this->fornecedor->cpf) {
                        $documento = 'CPF nº '.$this->fornecedor->cpf;
                    }
                }
                $recibo['documento'] = $documento;
                $recibo['descricao'] = $this->descricao;
                $recibo['recebido_de'] = $recebido_de;
                $recibo['nome_emitente'] = $s['razao_social'];
                break; 

            case 'pagar':
                $documento = 'CNPJ nº '.$s['documento'];
                $recebido_de = $s['razao_social'];
                $nome_emitente = '';
                if (!is_null($this->fornecedor)) {
                    $nome_emitente = $this->fornecedor->nome;
                    if (!empty($this->fornecedor->cnpj)) {
                        $nome_emitente .= ' - CNPJ nº '.$this->fornecedor->cnpj;
                    } else if ($this->fornecedor->cpf) {
                        $nome_emitente .= ' - CPF nº '.$this->fornecedor->cpf;
                    }
                }
                $recibo['documento'] = $documento;
                $recibo['descricao'] = $this->descricao;
                $recibo['recebido_de'] = $recebido_de;
                $recibo['nome_emitente'] = $nome_emitente;
                break; 
        }

        return $recibo;
    }

    public function listarItensLote()
    {
        return $this
            ->where('lote', $this->id)
            ->orderBy('vencimento')
            ->orderBy('valor')
            ->get();
    }

    public function atualizarPagamentoItensDeLote()
    {
        $itens = $this->listarItensLote();
        foreach ($itens as $item) {
            $item->pagamento = $this->pagamento;
            $item->save();
        }
    }

    /**
     * Quando um lançamento é excluido, 
     * deve liberar os lotes que estavam vinculados
     */
    public function desmontaLote()
    {
        $itens = $this->listarItensLote();
        foreach ($itens as $item) {
            $item->lote = null;
            $item->save();
        }
    }

    public static function processaSaldoConta($conta_id)
    {
        $params = DB::table('financeiro')
            ->select(
                // DB::raw("GREATEST(0, valor_pago) AS valor_inicial"),
                // DB::raw("LEAST(CURDATE(), DATE_ADD(emissao, INTERVAL 1 DAY)) AS data_inicial"),
                'pagamento AS data_inicial',
                DB::raw("
                    GREATEST (
                        DATE_ADD(CURDATE(), INTERVAL 1 MONTH),
                        (SELECT DATE_ADD(vencimento, INTERVAL 1 DAY) FROM financeiro WHERE vencimento != '' AND vencimento <= DATE_ADD(CURDATE(), INTERVAL 3 MONTH) AND deleted_at IS NULL ORDER BY vencimento DESC LIMIT 1),
                        (SELECT DATE_ADD(pagamento, INTERVAL 1 DAY)  FROM financeiro WHERE pagamento  != '' AND pagamento  <= DATE_ADD(CURDATE(), INTERVAL 3 MONTH) AND deleted_at IS NULL ORDER BY pagamento  DESC LIMIT 1)
                    ) AS data_final
                ")
            )
            ->where('saldo_inicial', 1)
            ->where('conta_id', $conta_id)
            ->limit(1)
            ->first();

        $sumEntradas = "COALESCE(SUM(CASE WHEN genero != 'pagar' THEN valor_pago END), 0)";
        $sumSaidas = "COALESCE(SUM(CASE WHEN genero = 'pagar' THEN valor_pago END), 0)";

        $queryRealizado = DB::table('financeiro')
            ->select('pagamento AS periodo', DB::raw("($sumEntradas - $sumSaidas) AS valor"))
            ->whereBetween('pagamento', [$params->data_inicial, $params->data_final])
            ->whereNotNull('tipo_lancamento')
            ->whereNull('lote')
            ->whereNull('deleted_at')
            ->where('conta_id', $conta_id)
            ->groupBy('pagamento')
            ->orderBy('pagamento')
            ->get();

        $queryPrevisao = DB::table('financeiro')
            ->select('vencimento AS periodo', DB::raw("($sumEntradas - $sumSaidas) AS valor"))
            ->whereBetween('vencimento', [$params->data_inicial, $params->data_final])
            // ->where(function($query) use ($params) {
            //     $query
            //         ->whereBetween('vencimento', [$params->data_inicial, $params->data_final])
            //         ->orWhereBetween('pagamento', [$params->data_inicial, $params->data_final]);
            // })
            ->whereNotNull('tipo_lancamento')
            ->whereNull('lote')
            ->whereNull('deleted_at')
            ->where('conta_id', $conta_id)
            ->groupBy('vencimento')
            ->orderBy('vencimento')
            ->get();

        $realizado = [];
        foreach ($queryRealizado as $key => $item) {
            $item->valor = (float) $item->valor;
            if ($key == 0) {
                $saldoAnterior = $item->valor;
                $item->acumulado = $saldoAnterior;
            } else {
                $saldoAnterior = $queryRealizado[$key-1]->acumulado; 
                $item->acumulado = $saldoAnterior + $item->valor;
            }
            $realizado[$item->periodo] = $item;
        }

        $previsao = [];
        foreach ($queryPrevisao as $key => $item) {
            $item->valor = (float) $item->valor;
            if ($key == 0) {
                $saldoAnterior = $item->valor;
                $item->acumulado = $saldoAnterior;
            } else {
                $saldoAnterior = $queryPrevisao[$key-1]->acumulado; 
                $item->acumulado = $saldoAnterior + $item->valor;
            }
            $previsao[$item->periodo] = $item;
        }

        $interval = new DateInterval('P1D');
        $daterange = new DatePeriod(Carbon::parse($params->data_inicial), $interval, Carbon::parse($params->data_final));
        $dados = [];
        $total_realizado = $total_previsao = 0;
        foreach ($daterange as $date) {
            $periodo = $date->format('Y-m-d');
            if (isset($realizado[$periodo])) {
                $total_realizado = $realizado[$periodo]->acumulado;
            }
            if (isset($previsao[$periodo])) {
                $total_previsao = $previsao[$periodo]->acumulado;
            }
            $dados[] = [
                'conta_id' => $conta_id,
                'periodo' => $periodo,
                'saldo' => $total_realizado,
                'previsao' => $total_previsao
            ];
        }

        DB::table('saldo')->insert($dados);
    }

    /*
    // DESATIVADO.
    // Lançamento deve ser manual para efetuar seleção correta dos atributos.
    public static function lancamentoAutomatico($tratamento)
    {
        $vencimentoSessao = $vencimentoConvenio = $vencimento = null;

        $dataUltimaSessao = $tratamento
            ->agendas()
            ->orderBy('sessao', 'desc')
            ->first()
            ->data_sessao;

        if ($dataUltimaSessao) {
            $vencimentoSessao = brDateToDatabase($dataUltimaSessao);

            // Dia de Vencimento do convênio é opcional.
            // Data última sessão é obrigatório.
            // Se um Dia de Vencimento for passado então esse dia será
            // definido como data de Vencimento.
            // Senão a data da última sessão será usada como Vencimento.

            // Monta a data baseado no dia de vencimento do convênio
            //var_dump($vencimentoSessao);
            $convDiaVenc = $tratamento->convenio->dia_vencimento;
            if ($convDiaVenc) {
                $dtVencSessao = explode('-', $vencimentoSessao);
                //$diaVencSessao = (int) $dtVencSessao[2];
                $mesVencSessao = (int) $dtVencSessao[1];
                $anoVencSessao = (int) $dtVencSessao[0];

                $convDiaVencLabel   = $convDiaVenc < 10 ? (string) '0'.$convDiaVenc : $convDiaVenc;
                $vencimentoConvenio = $anoVencSessao.'-'.$mesVencSessao.'-'.$convDiaVencLabel;
                if (strtotime($vencimentoConvenio) < strtotime($vencimentoSessao)) {
                    $vencimentoConvenio = strtotime(date($vencimentoConvenio));
                    $vencimento         = date('Y-m-d', strtotime('+1 month', $vencimentoConvenio));
                } else {
                    $vencimento = $vencimentoConvenio;
                }
            } else {
                $vencimento = $vencimentoSessao;
            }

            // Faz o lançamento
            $f                    = new self();
            $f->genero            = 'receber';
            $f->tratamento_id     = $tratamento->id;
            $f->codigo            = $tratamento->id;
            $f->documento_id      = 3; // Fatura
            $f->formapagamento_id = 5; // Depósito
            $f->emissao           = date('d-m-Y');
            $f->vencimento        = timestampToBr($vencimento);
            $f->valor             = $tratamento->total;
            $f->save();

            return true;
        } else {
            return false;
        }
    }
    */
}
