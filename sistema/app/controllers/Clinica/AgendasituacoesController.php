<?php

class AgendasituacoesController extends \BaseController {

    public function __construct() {

        User::allowedCredentials(array(10));
    }

    public function index(){

        $agendasituacoes = Agendasituacao::all();
        return View::make('agendasituacoes.index', compact('agendasituacoes'));
    }

    public function create(){

        $agendasituacao = new Agendasituacao;
        $action = route('agendasituacoesStore');
        return View::make('agendasituacoes.form', compact('agendasituacao', 'action'));
    }

    public function store(){

        $validator = Validator::make($data = Input::all(), Agendasituacao::$rules);
        if ($validator->fails()) {
            return Response::json([
                'status' => 'error', 
                'message' => 'Erro de validação. Informe os campos requeridos.', 
                'errors' => $validator->errors()
            ], 422);
        }
        $model = Agendasituacao::create($data);
        return Response::json([
            'status' => 'success', 
            'message' => 'Cadastro finalizado.',
            'model' => $model
        ], 200);
    }

    public function edit($id){

        $agendasituacao = Agendasituacao::find($id);
        $action = route('agendasituacoesUpdate', array('id' => $agendasituacao->id));
        return View::make('agendasituacoes.form', compact('agendasituacao', 'action'));
    }

    public function update($id){

        $model = Agendasituacao::findOrFail($id);
        $validator = Validator::make($data = Input::all(), Agendasituacao::$rules);
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

        $as = Agendasituacao::findOrFail($id);
        if ($as->uso_sistema) {
            return Redirect::route('agendasituacoes')
                ->with('fail', 'Registro de uso exclusivo do sistema.');
        } else {
            $as->delete();
            return Redirect::route('agendasituacoes')
                ->with('success', 'Registro removido.');
        }
    }

}
