<?php

class BancosController extends BasefinanceiroController {

    /**
     * Display a listing of bancos
     *
     * @return Response
     */
    public function index(){

        $bancos = Banco::all();
        return View::make('bancos.index', compact('bancos'));
    }

    /**
     * Show the form for creating a new banco
     *
     * @return Response
     */
    public function create(){

        $banco  = new Banco;
        $action = route('bancosStore');
        return View::make('bancos.form', compact('banco', 'action'));
    }

    /**
     * Store a newly created banco in storage.
     *
     * @return Response
     */
    public function store(){

        $validator = Validator::make($data = Input::all(), Banco::$rules);
        if ($validator->fails()) {
            return Response::json([
                'status' => 'error', 
                'message' => 'Erro de validação. Informe os campos requeridos.', 
                'errors' => $validator->errors()
            ], 422);
        }
        $model = Banco::create($data);
        return Response::json([
            'status' => 'success', 
            'message' => 'Cadastro finalizado.',
            'model' => $model
        ], 200);
    }

    /**
     * Show the form for editing the specified banco.
     *
     * @param  int  $id
     * @return Response
     */
    public function edit($id){

        $banco  = Banco::findOrFail($id);
        $action = route('bancosUpdate', array('id' => $banco->id));
        return View::make('bancos.form', compact('banco', 'action'));
    }

    /**
     * Update the specified banco in storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function update($id){

        $model = Banco::findOrFail($id);
        $validator = Validator::make($data = Input::all(), Banco::$rules);
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

    /**
     * Remove the specified banco from storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function destroy($id){

        Banco::destroy($id);
        return Redirect::back()->with('success', 'Registro removido.');
    }
}
