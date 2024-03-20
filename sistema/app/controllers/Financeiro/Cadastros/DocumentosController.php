<?php

class DocumentosController extends BasefinanceiroController {

    public function index(){

        $documentos = Documento::orderby('nome')->get();
        return View::make('documentos.index', compact('documentos'));
    }

    public function create(){

        $documento = new Documento;
        $action    = route('documentosStore');
        return View::make('documentos.form', compact('documento', 'action'));
    }

    public function store(){

        $validator = Validator::make($data = Input::all(), Documento::$rules);
        if ($validator->fails()) {
            return Response::json([
                'status' => 'error', 
                'message' => 'Erro de validação. Informe os campos requeridos.', 
                'errors' => $validator->errors()
            ], 422);
        }
        $model = Documento::create($data);
        return Response::json([
            'status' => 'success', 
            'message' => 'Cadastro finalizado.',
            'model' => $model
        ], 200);
    }

    public function edit($id){

        $documento = Documento::findOrFail($id);
        $action    = route('documentosUpdate', array('id' => $documento->id));
        return View::make('documentos.form', compact('documento', 'action'));
    }

    public function update($id){

        $model = Documento::findOrFail($id);
        $validator = Validator::make($data = Input::all(), Documento::$rules);
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

        Documento::destroy($id);
        return Redirect::back()->with('success', 'Registro removido.');
    }
}
