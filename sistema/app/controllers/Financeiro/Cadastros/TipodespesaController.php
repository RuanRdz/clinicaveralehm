<?php

class TipodespesaController extends BasefinanceiroController {

    public function index(){

        $tipodespesa = Tipodespesa::orderby('nome')->get();
        return View::make('tipodespesa.index', compact('tipodespesa'));
    }

    public function create(){

        $tipodespesa = new Tipodespesa;
        $action      = route('tipodespesaStore');
        return View::make('tipodespesa.form', compact('tipodespesa', 'action'));
    }

    public function store(){

        $validator = Validator::make($data = Input::all(), Tipodespesa::$rules);
        if ($validator->fails()) {
            return Response::json([
                'status' => 'error', 
                'message' => 'Erro de validação. Informe os campos requeridos.', 
                'errors' => $validator->errors()
            ], 422);
        }
        $model = Tipodespesa::create($data);
        return Response::json([
            'status' => 'success', 
            'message' => 'Cadastro finalizado.',
            'model' => $model
        ], 200);
    }

    public function edit($id){

        $tipodespesa = Tipodespesa::findOrFail($id);
        $action      = route('tipodespesaUpdate', array('id' => $tipodespesa->id));
        return View::make('tipodespesa.form', compact('tipodespesa', 'action'));
    }

    public function update($id){

        $model = Tipodespesa::findOrFail($id);
        $validator = Validator::make($data = Input::all(), Tipodespesa::$rules);
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

        Tipodespesa::destroy($id);
        return Redirect::back()->with('success', 'Registro removido.');
    }
}
