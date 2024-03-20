<?php

class EntradasController extends MovimentacaoController {

    public function __construct() {
        User::allowedCredentials(array(10));
    }

    // public function excel() {

    //     Financeiro::receberAdministrativoExcel();
    // }

    /**
     * @param int id tratamento_id
     */
    public function create(){

        $financeiro = new Financeiro;
        $action = route('financeiroStoreReceberAdm');
        $options = Financeiro::formOptions();
        $fornecedor = '';
        $cidade = '';
        return View::make(
            'financeiro.form-entrada',
            compact('financeiro', 'action', 'options', 'fornecedor', 'cidade')
        )
        ->nest('button_fk_fornecedor', 'layouts.admin.add-button-fk', ['url' => route('fornecedoresCreate'), 'seletor' => '#fornecedor_id'])
        ->nest('button_fk_formapagamento', 'layouts.admin.add-button-fk', ['url' => route('formapagamentoCreate'), 'seletor' => '#formapagamento_id'])
        ->nest('button_fk_documento', 'layouts.admin.add-button-fk', ['url' => route('documentosCreate'), 'seletor' => '#documento_id']);
        // ->nest('button_fk_conta', 'layouts.admin.add-button-fk', ['url' => route('contasCreate'), 'seletor' => '#conta_id'])
        // ->nest('button_fk_centrocusto', 'layouts.admin.add-button-fk', ['url' => route('centrocustoCreate'), 'seletor' => '#centrocusto_id'])
    }

    public function edit($id){

        $financeiro = Financeiro::with('fornecedor', 'conta', 'cidade')->findOrFail($id);
        $action = route('financeiroUpdateReceberAdm', array('id' => $financeiro->id));
        $options = Financeiro::formOptions();
        $fornecedor = $financeiro->fornecedor ? $financeiro->fornecedor->nome : '';
        $cidade = $financeiro->cidade ? $financeiro->cidade->nome.' - '.$financeiro->cidade->estado_uf : '';
        return View::make(
            'financeiro.form-entrada',
            compact('financeiro', 'action', 'options', 'fornecedor', 'cidade')
        )
        ->nest('button_fk_fornecedor', 'layouts.admin.add-button-fk', ['url' => route('fornecedoresCreate'), 'seletor' => '#fornecedor_id'])
        ->nest('button_fk_formapagamento', 'layouts.admin.add-button-fk', ['url' => route('formapagamentoCreate'), 'seletor' => '#formapagamento_id'])
        ->nest('button_fk_documento', 'layouts.admin.add-button-fk', ['url' => route('documentosCreate'), 'seletor' => '#documento_id']);
        // ->nest('button_fk_centrocusto', 'layouts.admin.add-button-fk', ['url' => route('centrocustoCreate'), 'seletor' => '#centrocusto_id'])
        // ->nest('button_fk_conta', 'layouts.admin.add-button-fk', ['url' => route('contasCreate'), 'seletor' => '#conta_id'])
    }

    public function store(){

        $post = Input::all();

        if (empty($post['fornecedor_id'])) {
            $post['fornecedor_id'] = Fornecedor::cadastroRapido($post['fornecedor']);
        }
        $validator = Validator::make($data = $post, Financeiro::$rulesReceberAdm);
        if ($validator->fails()){
            return Response::json([
                'status' => 'error', 
                'message' => 'Erro de validação. Informe os campos requeridos.', 
                'errors' => $validator->errors()
            ], 422);
        }
        $data['genero'] = 'receber-adm';

        // Todo lançamento feito pelo botão de lançamento na Movimentação 
        // entra como Individual 
        $data['tipo_lancamento'] = 'individual';
        if (empty($data['pagamento'])) {
            $data['valor_pago'] = $data['valor'];
            $data['desconto_taxa'] = 0;
            $data['juros_multa'] = 0;
        }
        if (isset($data['parcelamento_quantidade'])) {
            if ($data['parcelamento_quantidade'] > 1) {
                $parcelamento = $this->gerarParcelamento($data);
                foreach ($parcelamento['parcelas'] as $key => $value) {
                    $data['parcela'] = $value['parcela'];
                    $data['vencimento'] = $value['vencimento'];
                    $financeiro = Financeiro::create($data);
                    // Saldo::recalcular($financeiro);
                } 
            } else {
                $financeiro = Financeiro::create($data);
                // Saldo::recalcular($financeiro);
            }
        } else {
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

        $post = Input::all();
        if (empty($post['fornecedor_id'])) {
            $post['fornecedor_id'] = Fornecedor::cadastroRapido($post['fornecedor']);
        }
        $validator = Validator::make($data = $post, Financeiro::$rulesReceberAdm);
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
        // Saldo::recalcular($financeiro);

        return Response::json([
            'status' => 'success', 
            'message' => 'Cadastro finalizado.',
            'model' => $financeiro
        ], 200);
    }

}
