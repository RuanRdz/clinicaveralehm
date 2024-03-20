<?php

class MembrosController extends \BaseController {

    public function index(){

        // User::allowedCredentials(array(10, 20));
        $membros = Membro::orderby('nome')->paginate(50);
        return View::make('membros.index', compact('membros'));
    }

    public function create(){

        // User::allowedCredentials(array(10, 20));
        $membro = new Membro;
        $action = route('membrosStore');
        return View::make('membros.form', compact('membro', 'action'));
    }

    public function store(){

        // User::allowedCredentials(array(10, 20));
        $validator = Validator::make($data = Input::all(), Membro::$rules);
        if ($validator->fails()) {
            return Response::json([
                'status' => 'error', 
                'message' => 'Erro de validação. Informe os campos requeridos.', 
                'errors' => $validator->errors()
            ], 422);
        }
        $model = Membro::create($data);
        return Response::json([
            'status' => 'success', 
            'message' => 'Cadastro finalizado.',
            'model' => $model
        ], 200);
    }

    public function edit($id){

        User::allowedCredentials(array(10));
        $membro = Membro::findOrFail($id);
        $action = route('membrosUpdate', array('id' => $membro->id));
        return View::make('membros.form', compact('membro', 'action'));
    }

    public function update($id){

        User::allowedCredentials(array(10));
        $membro    = Membro::findOrFail($id);
        $validator = Validator::make($data = Input::all(), Membro::$rules);
        if ($validator->fails()){
            return Redirect::back()->withErrors($validator)->withInput();
        }
        $membro->update($data);
        return Redirect::route('membros')->with('success', 'Cadastro atualizado.');
    }

    public function destroy($id){

        User::allowedCredentials(array(10));
        Membro::destroy($id);
        return Redirect::back()->with('success', 'Registro removido.');
    }
}
