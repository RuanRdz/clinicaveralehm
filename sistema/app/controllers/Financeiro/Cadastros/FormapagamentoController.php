<?php

class FormapagamentoController extends BasefinanceiroController {

    public function index(){

        $formapagamento = Formapagamento::orderby('nome')->get();
        return View::make('formapagamento.index', compact('formapagamento'));
    }

    public function create(){

        $formapagamento = new Formapagamento;
        $action         = route('formapagamentoStore');
        return View::make('formapagamento.form', compact('formapagamento', 'action'));
    }

    public function store(){

        $validator = Validator::make($data = Input::all(), Formapagamento::$rules);
        if ($validator->fails()) {
            return Response::json([
                'status' => 'error', 
                'message' => 'Erro de validação. Informe os campos requeridos.', 
                'errors' => $validator->errors()
            ], 422);
        }
        $model = Formapagamento::create($data);
        return Response::json([
            'status' => 'success', 
            'message' => 'Cadastro finalizado.',
            'model' => $model
        ], 200);
    }

    public function edit($id){

        $formapagamento = Formapagamento::findOrFail($id);
        $action         = route('formapagamentoUpdate', array('id' => $formapagamento->id));
        return View::make('formapagamento.form', compact('formapagamento', 'action'));
    }

    public function update($id){

        $model = Formapagamento::findOrFail($id);
        $validator = Validator::make($data = Input::all(), Formapagamento::$rules);
        if ($validator->fails()){
            return Response::json([
                'status' => 'error', 
                'message' => 'Erro de validação. Informe os campos requeridos.', 
                'errors' => $validator->errors()
            ], 422);
        }
        $model->update($data);
        return Response::json([
            'status' => 'success', 
            'message' => 'Cadastro atualizado.',
            'model' => $model
        ], 200);
    }

    public function destroy($id){

        Formapagamento::destroy($id);
        return Redirect::back()->with('success', 'Registro removido.');
    }
}
