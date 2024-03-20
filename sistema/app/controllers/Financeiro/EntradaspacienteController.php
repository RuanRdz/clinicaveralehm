<?php

/**
 * Recebimento Particular (Pacientes)
 */
class EntradaspacienteController extends MovimentacaoController {

    public function __construct() {
        User::allowedCredentials(array(10, 30));
    }

    public function index() {

        if (Request::isMethod('post')) {
            Session::put('filtro_financeiro', Input::all());
        } else {
            Session::forget('filtro_financeiro');
        }
        // Verifica datas devido a opção "Mostrar todos" da movimentação
        if (empty(Session::get('filtro_financeiro.data_inicial')) || empty(Session::get('filtro_financeiro.data_final'))) {
            Session::put('filtro_financeiro.data_inicial', date('Y-m-d'));
            Session::put('filtro_financeiro.data_final', date('Y-m-d'));
        }

        $financeiro    = Financeiro::dados('receber')->get();
        $options       = Financeiro::formOptions();
        $filtroOptions = Financeiro::filtroOptions();
        $dados         = array('financeiro', 'filtroOptions', 'options');
        return View::make('financeiro.paciente', compact($dados));
    }

    public function excel() {
        User::allowedCredentials(array(10));
        Financeiro::pacientesExcel();
    }

    // Lançamento simples (sem opção de parcelamento)
    public function create($id){

        $tratamento    = Tratamento::findOrFail($id);
        $financeiro    = new Financeiro;
        $action        = route('financeiroStoreReceber');
        $options       = Financeiro::formOptions();
        $faturamento   = $tratamento->dadosFaturamento();
        return View::make(
            'financeiro.form-paciente',
            compact('financeiro', 'tratamento', 'action', 'options', 'faturamento')
        )
        // ->nest('button_fk_conta', 'layouts.admin.add-button-fk', ['url' => route('contasCreate'), 'seletor' => '#conta_id'])
        ->nest('button_fk_formapagamento', 'layouts.admin.add-button-fk', ['url' => route('formapagamentoCreate'), 'seletor' => '#formapagamento_id'])
        ->nest('button_fk_documento', 'layouts.admin.add-button-fk', ['url' => route('documentosCreate'), 'seletor' => '#documento_id']);
    }

    // Lançamento parcelado para faturamento de sessões particulares    
    public function createParcelado($id) 
    {
        $tratamento    = Tratamento::findOrFail($id);
        $financeiro    = new Financeiro;
        $action        = route('financeiroStoreReceberParcelado');
        $options       = Financeiro::formOptions();
        $faturamento   = $tratamento->dadosFaturamento();
        return View::make(
            'financeiro.form-paciente-parcelado',
            compact('financeiro', 'tratamento', 'action', 'options', 'faturamento')
        )
        // ->nest('button_fk_conta', 'layouts.admin.add-button-fk', ['url' => route('contasCreate'), 'seletor' => '#conta_id'])
        ->nest('button_fk_formapagamento', 'layouts.admin.add-button-fk', ['url' => route('formapagamentoCreate'), 'seletor' => '#formapagamento_id'])
        ->nest('button_fk_documento', 'layouts.admin.add-button-fk', ['url' => route('documentosCreate'), 'seletor' => '#documento_id']);
    }

    /*
    // DESATIVADO.
    // Lançamento deve ser manual para efetuar seleção correta dos atributos.

    public function createAutomatico($id){

        $tratamento = Tratamento::findOrFail($id);
        if (Financeiro::lancamentoAutomatico($tratamento)) {
            return Redirect::route(
                'painel',
                array(
                    'id' => $tratamento->paciente->id,
                    'id2' => $tratamento->id
                )
            )->with('success', 'Cadastro automático finalizado.');
        } else {
            return Redirect::route(
                'painel',
                array(
                    'id' => $tratamento->paciente->id,
                    'id2' => $tratamento->id
                )
            )->with('fail', 'Data da <b>última sessão</b> na Agenda é requerida para lançamento automático.');
        }
    }
    */

    public function edit($id){

        $financeiro    = Financeiro::findOrFail($id);
        $tratamento    = $financeiro->tratamento;
        $action        = route('financeiroUpdateReceber', array('id' => $financeiro->id));
        $options       = Financeiro::formOptions();
        $faturamento   = $tratamento->dadosFaturamento();
        return View::make(
            'financeiro.form-paciente',
            compact('financeiro', 'tratamento', 'action', 'options', 'faturamento')
        )
        // ->nest('button_fk_conta', 'layouts.admin.add-button-fk', ['url' => route('contasCreate'), 'seletor' => '#conta_id'])
        ->nest('button_fk_formapagamento', 'layouts.admin.add-button-fk', ['url' => route('formapagamentoCreate'), 'seletor' => '#formapagamento_id'])
        ->nest('button_fk_documento', 'layouts.admin.add-button-fk', ['url' => route('documentosCreate'), 'seletor' => '#documento_id']);
    }

    public function store(){

        $validator = Validator::make($data = Input::all(), Financeiro::$rulesReceber);
        if ($validator->fails()){
            return Response::json([
                'status' => 'error', 
                'message' => 'Erro de validação. Informe os campos requeridos.', 
                'errors' => $validator->errors()
            ], 422);
        }
        $data['genero'] = 'receber';

        if (empty($data['pagamento'])) {
            $data['valor_pago'] = $data['valor'];
            $data['desconto_taxa'] = 0;
            $data['juros_multa'] = 0;
        }

        // Só define o tipo lançamento e lote na tela Pacientes ao Gerar Entrada
        $data['tipo_lancamento'] = null;
        $data['lote'] = null;
        
        $financeiro = Financeiro::create($data);

        return Response::json([
            'status' => 'success', 
            'message' => 'Cadastro finalizado.',
            'model' => $financeiro
        ], 200);
    }

    public function storeParcelado(){

        $validator = Validator::make($data = Input::all(), Financeiro::$rulesReceber);
        if ($validator->fails()){
            return Response::json([
                'status' => 'error', 
                'message' => 'Erro de validação. Informe os campos requeridos.', 
                'errors' => $validator->errors()
            ], 422);
        }
        $data['genero'] = 'receber';
        $data['valor_pago'] = $data['valor'];
        $obs = $data['observacao'];

        $parcelamento = $this->gerarParcelamento($data);
        foreach ($parcelamento['parcelas'] as $key => $value) {
            $data['parcela'] = $value['parcela'];
            $data['vencimento'] = $value['vencimento'];
            $data['observacao'] = $obs.' Ref.: '.$data['parcela'];
            $financeiro = Financeiro::create($data);
            // Saldo::recalcular($financeiro);
        }

        return Response::json([
            'status' => 'success', 
            'message' => 'Cadastro finalizado.',
            'model' => null
        ], 200);
    }

    public function update($id){

        $financeiro = Financeiro::findOrFail($id);
        $validator  = Validator::make($data = Input::all(), Financeiro::$rulesReceber);
        if ($validator->fails()){
            return Response::json([
                'status' => 'error', 
                'message' => 'Erro de validação. Informe os campos requeridos.', 
                'errors' => $validator->errors()
            ], 422);
        }
        if (empty($data['pagamento'])) {
            $data['valor_pago'] = $data['valor'];
            $data['desconto_taxa'] = 0;
            $data['juros_multa'] = 0;
        }
        $financeiro->update($data);
        $financeiro->atualizarPagamentoItensDeLote();
        return Response::json([
            'status' => 'success', 
            'message' => 'Cadastro finalizado.',
            'model' => $financeiro
        ], 200);
    }

    public function gerarEntrada() 
    {
        User::allowedCredentials(array(10));
        $post = Input::all();

        switch ($post['tipo_lancamento']) {
            case 'individual':
                foreach ($post['ids_lancamentos'] as $id) {
                    $item = Financeiro::find($id);
                    if ($item) {
                        $item->tipo_lancamento = 'individual';
                        $item->save();
                    }
                }
                break;

            case 'lote':
                $financeiro = new Financeiro;
                $financeiro->fornecedor_id = $post['fornecedor_id'];
                $financeiro->conta_id = $post['conta_id'];
                $financeiro->centrocusto_id = $post['centrocusto_id'];
                // $financeiro->tipodespesa_id = $post['tipodespesa_id']; // desativado
                $financeiro->formapagamento_id = $post['formapagamento_id'];
                $financeiro->documento_id = $post['documento_id'];
                $financeiro->emissao = $post['emissao'];
                $financeiro->vencimento = $post['vencimento'];
                $financeiro->pagamento = $post['pagamento'];
                $financeiro->valor = $post['valor'];
                $financeiro->desconto_taxa = $post['desconto_taxa'];
                $financeiro->juros_multa = $post['juros_multa'];
                $financeiro->valor_pago = $post['valor_pago'];
                $financeiro->genero = 'receber-adm';
                $financeiro->tipo_lancamento = 'lote';
                $financeiro->lote = null;
                $financeiro->parcela = 1;
                $financeiro->descricao = $post['descricao'];
                $financeiro->save();

                $ids_tratamentos = [];
                foreach ($post['ids_lancamentos'] as $id) {
                    $item = Financeiro::find($id);
                    if ($item) {
                        $item->tipo_lancamento = null;
                        $item->lote = $financeiro->id;
                        $item->save();
                        $ids_tratamentos[] = $item->tratamento_id;
                    }
                }
                $financeiro->atualizarPagamentoItensDeLote();

                // Finalizar Tratamentos?
                if (isset($post['finalizar_tratamentos'])) {
                    if ($post['finalizar_tratamentos'] == 1) {
                        $ids_tratamentos = array_unique($ids_tratamentos);
                        foreach ($ids_tratamentos as $id_t) {
                            $t = Tratamento::find($id_t);
                            if ($t) {
                                $t->tratamentosituacao_id = 2;
                                $t->save();
                            }
                        }
                    }
                }

                break;
        }

        return Response::json([
            'status' => 'success', 
            'message' => 'Lançamento finalizado',
        ], 200);
    }
}
