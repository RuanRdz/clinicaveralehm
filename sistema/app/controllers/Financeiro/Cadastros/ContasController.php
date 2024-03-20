<?php

class ContasController extends BasefinanceiroController {

    public $labelsYN = array(1 => 'Sim', 0 => 'Não');

    public function index(){

        $contas = Conta::orderby('nome')->get();
        $labelsYN = $this->labelsYN;
        return View::make('contas.index', compact('contas', 'labelsYN'));
    }

    public function create(){

        $conta  = new Conta;
        $rules = Conta::$rules;
        $action = route('contasStore');
        return View::make('contas.form', compact('conta', 'rules', 'action'));
    }

    public function store(){

        $validator = Validator::make($data = Input::all(), Conta::$rules);
        if ($validator->fails()) {
            return Response::json([
                'status' => 'error', 
                'message' => 'Erro de validação. Informe os campos requeridos.', 
                'errors' => $validator->errors()
            ], 422);
        }
        $model = Conta::create($data);
        $model->atualizaSaldoInicial($data['valor_saldo'], $data['data_saldo']);
        return Response::json([
            'status' => 'success', 
            'message' => 'Cadastro finalizado.',
            'model' => $model
        ], 200);
    }

    public function edit($id){

        $conta = Conta::findOrFail($id);
        $conta->valor_saldo = '';
        $conta->data_saldo = '';
        $saldoInicial = $conta->loadSaldoInicial();
        if (!empty($saldoInicial)) {
            $conta->valor_saldo = $saldoInicial->valor;
            $conta->data_saldo = $saldoInicial->emissao;
        }
        $rules = Conta::$rules;
        $action = route('contasUpdate', array('id' => $conta->id));
        return View::make('contas.form', compact('conta', 'rules', 'action'));
    }

    public function update($id){

        $model = Conta::findOrFail($id);
        $validator = Validator::make($data = Input::all(), Conta::$rules);
        if ($validator->fails()){
            return Response::json([
                'status' => 'error', 
                'message' => 'Erro de validação. Informe os campos requeridos.', 
                'errors' => $validator->errors()
            ], 422);
        }
        $model->update($data);
        $model->atualizaSaldoInicial($data['valor_saldo'], $data['data_saldo']);
        return Response::json([
            'status' => 'success', 
            'message' => 'Cadastro atualizado.',
            'model' => $model
        ], 200);
    }

    public function destroy($id){

        Conta::destroy($id);
        return Redirect::back()->with('success', 'Registro removido.');
    }
}
