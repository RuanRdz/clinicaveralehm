<?php

class SaidasController extends MovimentacaoController {

    public function __construct() {
        User::allowedCredentials(array(10));
    }

    // public function excel() {

    //     Financeiro::pagarExcel();
    // }

    public function create(){

        $financeiro       = new Financeiro;
        $action           = route('financeiroStorePagar');
        $options          = Financeiro::formOptions();
        $fornecedor       = '';
        $cidade           = '';
        return View::make(
            'financeiro.form-saida',
            compact('financeiro', 'action', 'options', 'fornecedor', 'cidade')
        )
        ->nest('button_fk_fornecedor', 'layouts.admin.add-button-fk', ['url' => route('fornecedoresCreate'), 'seletor' => '#fornecedor_id'])
        ->nest('button_fk_formapagamento', 'layouts.admin.add-button-fk', ['url' => route('formapagamentoCreate'), 'seletor' => '#formapagamento_id'])
        ->nest('button_fk_documento', 'layouts.admin.add-button-fk', ['url' => route('documentosCreate'), 'seletor' => '#documento_id'])
        ->nest('button_fk_tipodespesa', 'layouts.admin.add-button-fk', ['url' => route('tipodespesaCreate'), 'seletor' => '#tipodespesa_id']);
        // ->nest('button_fk_conta', 'layouts.admin.add-button-fk', ['url' => route('contasCreate'), 'seletor' => '#conta_id'])
        // ->nest('button_fk_centrocusto', 'layouts.admin.add-button-fk', ['url' => route('centrocustoCreate'), 'seletor' => '#centrocusto_id'])
    }

    public function edit($id){

        $financeiro       = Financeiro::findOrFail($id);
        $action           = route('financeiroUpdatePagar', array('id' => $financeiro->id));
        $options          = Financeiro::formOptions();
        $fornecedor       = $financeiro->fornecedor ? $financeiro->fornecedor->nome : '';
        $cidade           = $financeiro->cidade ? $financeiro->cidade->nome.' - '.$financeiro->cidade->estado_uf : '';
        return View::make(
            'financeiro.form-saida',
            compact('financeiro', 'action', 'options', 'fornecedor', 'cidade')
        )
        ->nest('button_fk_fornecedor', 'layouts.admin.add-button-fk', ['url' => route('fornecedoresCreate'), 'seletor' => '#fornecedor_id'])
        ->nest('button_fk_formapagamento', 'layouts.admin.add-button-fk', ['url' => route('formapagamentoCreate'), 'seletor' => '#formapagamento_id'])
        ->nest('button_fk_documento', 'layouts.admin.add-button-fk', ['url' => route('documentosCreate'), 'seletor' => '#documento_id'])
        ->nest('button_fk_tipodespesa', 'layouts.admin.add-button-fk', ['url' => route('tipodespesaCreate'), 'seletor' => '#tipodespesa_id']);
        // ->nest('button_fk_centrocusto', 'layouts.admin.add-button-fk', ['url' => route('centrocustoCreate'), 'seletor' => '#centrocusto_id'])
        // ->nest('button_fk_conta', 'layouts.admin.add-button-fk', ['url' => route('contasCreate'), 'seletor' => '#conta_id'])
    }

    public function store(){

        $post = Input::all();
        if (empty($post['fornecedor_id'])) {
            $post['fornecedor_id'] = Fornecedor::cadastroRapido($post['fornecedor']);
        }
        $validator = Validator::make($data = $post, Financeiro::$rulesPagar);
        if ($validator->fails()){
            return Response::json([
                'status' => 'error', 
                'message' => 'Erro de validação. Informe os campos requeridos.', 
                'errors' => $validator->errors()
            ], 422);
        }

        $data['genero'] = 'pagar';

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
                    $data['parcela']    = $value['parcela'];
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
        $validator = Validator::make($data = $post, Financeiro::$rulesPagar);
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
        // Saldo::recalcular($financeiro);

        return Response::json([
            'status' => 'success', 
            'message' => 'Cadastro finalizado.',
            'model' => $financeiro
        ], 200);
    }
}
