<?php

class LesoesController extends \BaseController {

    /**
     * Display a listing of lesoes
     *
     * @return Response
     */
    public function index(){

        // User::allowedCredentials(array(10, 20));
        $lesoes = Lesao::orderby('nome')->paginate(50);
        return View::make('lesoes.index', compact('lesoes'));
    }

    /**
     * Show the form for creating a new leso
     *
     * @return Response
     */
    public function create(){

        // User::allowedCredentials(array(10, 20));
        $lesao  = new Lesao;
        $action = route('lesoesStore');
        return View::make('lesoes.form', compact('lesao', 'action'));
    }

    /**
     * Store a newly created lesao in storage.
     *
     * @return Response
     */
    public function store(){

        // User::allowedCredentials(array(10, 20));
        $validator = Validator::make($data = Input::all(), Lesao::$rules);
        if ($validator->fails()) {
            return Response::json([
                'status' => 'error', 
                'message' => 'Erro de validação. Informe os campos requeridos.', 
                'errors' => $validator->errors()
            ], 422);
        }
        $model = Lesao::create($data);
        return Response::json([
            'status' => 'success', 
            'message' => 'Cadastro finalizado.',
            'model' => $model
        ], 200);
    }

    /**
     * Show the form for editing the specified lesao.
     *
     * @param  int  $id
     * @return Response
     */
    public function edit($id){

        User::allowedCredentials(array(10));
        $lesao  = Lesao::findOrFail($id);
        $action = route('lesoesUpdate', array('id' => $lesao->id));
        return View::make('lesoes.form', compact('lesao', 'action'));
    }

    /**
     * Update the specified lesao in storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function update($id){

        User::allowedCredentials(array(10));
        $model = Lesao::findOrFail($id);
        $validator = Validator::make($data = Input::all(), Lesao::$rules);
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
     * Remove the specified lesao from storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function destroy($id){

        User::allowedCredentials(array(10));
        Lesao::destroy($id);
        return Redirect::back()->with('success', 'Registro removido.');
    }
}
