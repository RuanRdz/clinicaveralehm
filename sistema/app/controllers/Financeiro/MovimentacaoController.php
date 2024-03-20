<?php

class MovimentacaoController extends BasefinanceiroController {

    public function __construct() {
        User::allowedCredentials(array(10));
    }

    public function index() 
    {
        // Session::forget('filtro_financeiro');
        $filtroOptions = Financeiro::filtroOptions();

        $init = [
            'route_financeiro_movimentacao_json' => route('financeiroMovimentacaoJson'),
            'filtro' => [
                'periodo_selecionado' => Session::get('filtro_financeiro.periodo_selecionado', ''),
                'show_dropdown_periodo' => Session::get('filtro_financeiro.show_dropdown_periodo', 1),
                'texto_periodo' => Session::get('filtro_financeiro.texto_periodo', ''),
                'data_inicial' => Session::get('filtro_financeiro.data_inicial', ''),
                'data_final' => Session::get('filtro_financeiro.data_final', ''),
                'tipomovimentacao_entradas' => Session::get('filtro_financeiro.tipomovimentacao_entradas', 1),
                'tipomovimentacao_saidas' => Session::get('filtro_financeiro.tipomovimentacao_saidas', 1),
                'situacao' => Session::get('filtro_financeiro.situacao', []),
                'busca' => Session::get('filtro_financeiro.busca', ''),
                'fornecedor_id' => Session::get('filtro_financeiro.fornecedor_id', ''),
                'conta_id' => Session::get('filtro_financeiro.conta_id', []),
                'centrocusto_id' => Session::get('filtro_financeiro.centrocusto_id', []),
                'tipodespesa_id' => Session::get('filtro_financeiro.tipodespesa_id', []),
                'formapagamento_id' => Session::get('filtro_financeiro.formapagamento_id', []),
                'documento_id' => Session::get('filtro_financeiro.documento_id', []),
                'cidade_id' => Session::get('filtro_financeiro.cidade_id', [])
            ]
        ];
        
        return View::make('financeiro.movimentacao', compact(['init', 'filtroOptions']));
    }

    /** Dados para listagem Angular */
    public function movimentacaoJson() 
    {
        if (Request::isMethod('post')) {
            $filtro = json_decode(Input::get('filtro_json'), true);
            Session::put('filtro_financeiro', $filtro);
        } 
        $financeiro = Financeiro::movimentacao();
        return Response::json($financeiro, 200);
    }    

    public function excel() {

        Financeiro::contabilidadeExcel();
    }

    /**
     * Form para atualização data de pagamento de
     * lançamentos marcados na listagem.
     */
    public function updatePagamentoListagem() {

        $post = Input::all();
        if (isset($post['pagamento'])) {
            if (isset($post['itens'])) {
                foreach ($post['itens'] as $id) {
                    $financeiro = Financeiro::find((int) $id);
                    $financeiro->pagamento = $post['pagamento'];
                    $financeiro->save();
                    $financeiro->atualizarPagamentoItensDeLote();
                    // Saldo::recalcular($financeiro);
                }
            }
            return 1;
        } else {
            return View::make('financeiro.form-update-pagamento');
        }
    }

    public function destroy($id) {
        User::allowedCredentials(array(10));
        $financeiro = Financeiro::find($id);
        $financeiro->desmontaLote();
        Financeiro::destroy($id);
        // Saldo::recalcular($financeiro);
        return Redirect::back()->with('success', 'Registro removido.');
    }

    public function duplicate($id) {

        $attributes = Financeiro::findOrFail($id)->toArray();
        unset($attributes['id']);
        $newEntry = Financeiro::create($attributes);
        switch ($newEntry->genero) {
            case 'receber':     $newEntryEditRoute = 'financeiroEditReceber'; break;
            case 'receber-adm': $newEntryEditRoute = 'financeiroEditReceberAdm'; break;
            case 'pagar':       $newEntryEditRoute = 'financeiroEditPagar'; break;
        }

        // Request Forward
        // Acessa o controller relacionado para obter 
        // a view correspondente ao gênero do lançamento
        $request = Request::create(route($newEntryEditRoute, array('id' => $newEntry->id)), 'GET', array());
        return Route::dispatch($request);  
    }

    public function simularParcelamento()
    {
        $post = Input::all();
        if (
            empty($post['parcelamento_quantidade']) 
            || empty($post['parcelamento_periodo'])
            || empty($post['valor'])
        ) {
            return '<span class="text-red-500">Para simulação, informar: Valor, Número de Parcelas e Período.</span>';
        }
        $parcelamento = $this->gerarParcelamento($post);
        return View::make(
            'financeiro.simulacao-parcelamento', compact('parcelamento')
        );
    }

    public function gerarParcelamento($data) {

        $valor = valorFloat($data['valor']);
        switch ($data['parcelamento_periodo']) {
            case 'semanal':     $periodo = ' +1 week';   break;
            case 'mensal':      $periodo = ' +1 month';  break;
            case 'bimestral':   $periodo = ' +2 months'; break;
            case 'trimestral':  $periodo = ' +3 months'; break;
            case 'semestral':   $periodo = ' +6 months'; break;
            case 'anual':       $periodo = ' +1 year';   break;
            default :           $periodo = ' +1 month';  break;
        }
        $resultadoSimulacao = array();
        $valorTotal = 0;
        for ($p=1; $p < ($data['parcelamento_quantidade'] + 1); $p++) {
            if ($p == 1) {
                $date = new DateTime($data['vencimento']);
            } else {
                $date = new DateTime($data['vencimento'].$periodo);
            }
            $data['vencimento'] = $date->format('d').'-'.$date->format('m').'-'.$date->format('Y');
            $data['parcela'] = $p.'/'.$data['parcelamento_quantidade'];

            $valorTotal = $valorTotal + $valor;
            $resultadoSimulacao[] = array(
                'parcela'    => $data['parcela'],
                'vencimento' => $data['vencimento'],
                'valor'      => valorBr($valor),
            );
        }
        return array(
            'parcelas' => $resultadoSimulacao,
            'total'    => valorBr($valorTotal),
        );
    }

    public function financeiroTransferenciaContas(){

        $post = Input::all();
        $validator = Validator::make($data = $post, Financeiro::$rulesTransferenciaContas);
        if ($validator->fails()) {
            return Redirect::back()->withErrors($validator)->withInput();
        }

        $contaOrigem = Conta::findOrFail($data['origem_conta_id']);
        $contaDestino = Conta::findOrFail($data['destino_conta_id']);

        $data['emissao'] = $data['data_transferencia'];
        $data['vencimento'] = $data['data_transferencia'];
        $data['pagamento'] = $data['data_transferencia'];
        $data['parcela'] = '1';
        $data['valor_pago'] = $data['valor'];
        $data['tipo'] = $data['tipo'];

        // Lançamento débito
        $data['tipo_lancamento'] = 'transferencia';
        $data['genero'] = 'pagar';
        $data['codigo'] = date('YmdHis').'.saida';
        $data['conta_id'] = $contaOrigem->id;
        $data['descricao'] = 'Transferido para conta: '.$contaDestino->nome;
        $data['observacao'] = 'Transferido para conta: '.$contaDestino->nome;
        Financeiro::create($data);

        // Lançamento crédito
        $data['tipo_lancamento'] = 'transferencia';
        $data['genero'] = 'receber-adm';
        $data['codigo'] = date('YmdHis').'.entrada';
        $data['conta_id'] = $contaDestino->id;
        $data['descricao'] = 'Transferido da conta: '.$contaOrigem->nome;
        $data['observacao'] = 'Transferido da conta: '.$contaOrigem->nome;
        Financeiro::create($data);

        return Redirect::back()->with('success', 'Transferência finalizada.');
    }
    
    public function listarItensLote($id)
    {
        $financeiro = Financeiro::findOrFail($id);
        $itens = $financeiro->listarItensLote();

        return View::make('financeiro.lista-itens-lote', compact('financeiro', 'itens'));
    }
}
