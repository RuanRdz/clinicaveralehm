<?php

class CentrocustoController extends BasefinanceiroController {


    public function index(){

        $centrocusto = Centrocusto::orderby('nome')->get();
        return View::make('centrocusto.index', compact('centrocusto'));
    }

    public function create(){

        $centrocusto = new Centrocusto;
        $action      = route('centrocustoStore');
        return View::make('centrocusto.form', compact('centrocusto', 'action'));
    }

    public function store(){

        $validator = Validator::make($data = Input::all(), Centrocusto::$rules);
        if ($validator->fails()) {
            return Response::json([
                'status' => 'error', 
                'message' => 'Erro de validação. Informe os campos requeridos.', 
                'errors' => $validator->errors()
            ], 422);
        }
        $model = Centrocusto::create($data);
        return Response::json([
            'status' => 'success', 
            'message' => 'Cadastro finalizado.',
            'model' => $model
        ], 200);
    }

    public function edit($id){

        $centrocusto = Centrocusto::findOrFail($id);
        $action      = route('centrocustoUpdate', array('id' => $centrocusto->id));
        return View::make('centrocusto.form', compact('centrocusto', 'action'));
    }

    public function update($id){

        $model = Centrocusto::findOrFail($id);
        $validator = Validator::make($data = Input::all(), Centrocusto::$rules);
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

        Centrocusto::destroy($id);
        return Redirect::back()->with('success', 'Registro removido.');
    }
}
