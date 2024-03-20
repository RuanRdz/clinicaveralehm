<?php

class MedicosController extends \BaseController {

    /**
     * Display a listing of medicos
     *
     * @return Response
     */
    public function index(){

        User::allowedCredentials(array(10, 20));
        $medicos = Medico::orderby('nome')->paginate(50);
        return View::make('medicos.index', compact('medicos'));
    }

    /**
     * Show the form for creating a new medico
     *
     * @return Response
     */
    public function create(){

        // User::allowedCredentials(array(10, 20));
        $medico = new Medico;
        $action = route('medicosStore');
        return View::make('medicos.form', compact('medico', 'action'));
    }

    /**
     * Store a newly created medico in storage.
     *
     * @return Response
     */
    public function store(){

        // User::allowedCredentials(array(10, 20));
        $validator = Validator::make($data = Input::all(), Medico::$rules);
        if ($validator->fails()) {
            return Response::json([
                'status' => 'error', 
                'message' => 'Erro de validação. Informe os campos requeridos.', 
                'errors' => $validator->errors()
            ], 422);
        }
        $model = Medico::create($data);
        return Response::json([
            'status' => 'success', 
            'message' => 'Cadastro finalizado.',
            'model' => $model
        ], 200);
    }

    /**
     * Show the form for editing the specified medico.
     *
     * @param  int  $id
     * @return Response
     */
    public function edit($id){

        User::allowedCredentials(array(10));
        $medico = Medico::findOrFail($id);
        $action = route('medicosUpdate', array('id' => $medico->id));
        return View::make('medicos.form', compact('medico', 'action'));
    }

    /**
     * Update the specified medico in storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function update($id){

        User::allowedCredentials(array(10));
        $model = Medico::findOrFail($id);
        $validator = Validator::make($data = Input::all(), Medico::$rules);
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
     * Remove the specified medico from storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function destroy($id){

        User::allowedCredentials(array(10));
        Medico::destroy($id);
        return Redirect::back()->with('success', 'Registro removido.');
    }
}
