<?php

class ConveniotiposController extends \BaseController {

    /**
     * Display a listing of conveniotipos
     *
     * @return Response
     */
    public function index(){

        User::allowedCredentials(array(10));
        $conveniotipos = Conveniotipo::all();
        return View::make('conveniotipos.index', compact('conveniotipos'));
    }

    /**
     * Show the form for creating a new membro
     *
     * @return Response
     */
    public function create(){

        User::allowedCredentials(array(10));
        $conveniotipo = new Conveniotipo;
        $action       = route('conveniotiposStore');
        return View::make('conveniotipos.form', compact('conveniotipo', 'action'));
    }

    /**
     * Store a newly created membro in storage.
     *
     * @return Response
     */
    public function store(){

        User::allowedCredentials(array(10));
        $validator = Validator::make($data = Input::all(), Conveniotipo::$rules);
        if ($validator->fails()){
            return Response::json([
                'status' => 'error', 
                'message' => 'Erro de validação. Informe os campos requeridos.', 
                'errors' => $validator->errors()
            ], 422);
        }
        $model = Conveniotipo::create($data);
        return Response::json([
            'status' => 'success', 
            'message' => 'Cadastro finalizado.',
            'model' => $model
        ], 200);
    }

    /**
     * Show the form for editing the specified membro.
     *
     * @param  int  $id
     * @return Response
     */
    public function edit($id){

        User::allowedCredentials(array(10));
        $conveniotipo = Conveniotipo::findOrFail($id);
        $action       = route('conveniotiposUpdate', array('id' => $conveniotipo->id));
        return View::make('conveniotipos.form', compact('conveniotipo', 'action'));
    }

    /**
     * Update the specified membro in storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function update($id){

        User::allowedCredentials(array(10));
        $model = Conveniotipo::findOrFail($id);
        $validator = Validator::make($data = Input::all(), Conveniotipo::$rules);
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
     * Remove the specified membro from storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function destroy($id){

        User::allowedCredentials(array(10));
        Conveniotipo::destroy($id);
        return Redirect::back()->with('success', 'Registro removido.');
    }

}
