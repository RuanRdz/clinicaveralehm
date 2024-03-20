<?php

class TextosprontuarioController extends \BaseController {

    public function index(){

        User::allowedCredentials(array(10,20,30));
        $dados = Textosprontuario::orderby('ordem')->get();

        return View::make('textosprontuario.index', compact('dados'));
    }

    public function indexJson(){

        User::allowedCredentials(array(10,20,30));
        $dados = Textosprontuario::orderby('ordem')->get();

        return Response::json($dados);
    }

    /**
     * Show the form for creating a new text
     *
     * @return Response
     */
    public function create(){

        User::allowedCredentials(array(10));
        $dados  = new Textosprontuario;
        $ultimaOrdem = Textosprontuario::orderBy('ordem', 'desc')->first();
        $dados->ordem = 1;
        if ($ultimaOrdem) {
            $dados->ordem = $ultimaOrdem->ordem + 1;
        }
        $action = route('textosprontuarioStore');
        return View::make('textosprontuario.form', compact('dados', 'action'));
    }

    /**
     * Store a newly created textosprontuario in storage.
     *
     * @return Response
     */
    public function store(){

        User::allowedCredentials(array(10));
        $validator = Validator::make($data = Input::all(), Textosprontuario::$rules);
        if ($validator->fails()) {
            return Response::json([
                'status' => 'error', 
                'message' => 'Erro de validação. Informe os campos requeridos.', 
                'errors' => $validator->errors()
            ], 422);
        }
        $model = Textosprontuario::create($data);
        return Response::json([
            'status' => 'success', 
            'message' => 'Cadastro finalizado.',
            'model' => $model
        ], 200);
    }


    /**
     * Show the form for editing the specified textosprontuario.
     *
     * @param  int  $id
     * @return Response
     */
    public function edit($id){

        User::allowedCredentials(array(10));
        $dados  = Textosprontuario::findOrFail($id);
        $action = route('textosprontuarioUpdate', array('id' => $dados->id));
        return View::make('textosprontuario.form', compact('dados', 'action'));
    }

    /**
     * Update the specified textosprontuario in storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function update($id){

        User::allowedCredentials(array(10));
        $model = Textosprontuario::findOrFail($id);
        $validator = Validator::make($data = Input::all(), Textosprontuario::$rules);
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
     * Remove the specified textosprontuario from storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function destroy($id){

        User::allowedCredentials(array(10));
        Textosprontuario::destroy($id);
        return Redirect::back()->with('success', 'Registro removido.');
    }
}
