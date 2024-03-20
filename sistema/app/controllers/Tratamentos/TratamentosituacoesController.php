<?php

class TratamentosituacoesController extends \BaseController {

    public function __construct() {

        User::allowedCredentials(array(10));
    }

    /**
     * Display a listing of tratamentosituacoes
     *
     * @return Response
     */
    public function index(){

        $tratamentosituacoes = Tratamentosituacao::all();
        return View::make('tratamentosituacoes.index', compact('tratamentosituacoes'));
    }

    /**
     * Show the form for creating a new tratamentosituacao
     *
     * @return Response
     */
    public function create(){

        $tratamentosituacao = new Tratamentosituacao;
        $action             = route('tratamentosituacoesStore');
        return View::make('tratamentosituacoes.form', compact('tratamentosituacao', 'action'));
    }

    /**
     * Store a newly created tratamentosituacao in storage.
     *
     * @return Response
     */
    public function store(){

        $validator = Validator::make($data = Input::all(), Tratamentosituacao::$rules);
        if ($validator->fails()) {
            return Response::json([
                'status' => 'error', 
                'message' => 'Erro de validação. Informe os campos requeridos.', 
                'errors' => $validator->errors()
            ], 422);
        }
        $model = Tratamentosituacao::create($data);
        return Response::json([
            'status' => 'success', 
            'message' => 'Cadastro finalizado.',
            'model' => $model
        ], 200);
    }

    /**
     * Display the specified tratamentosituacao.
     *
     * @param  int  $id
     * @return Response
     */
    public function show($id){

        $tratamentosituacao = Tratamentosituacao::findOrFail($id);
        return View::make('tratamentosituacoes.show', compact('tratamentosituacao'));
    }

    /**
     * Show the form for editing the specified tratamentosituacao.
     *
     * @param  int  $id
     * @return Response
     */
    public function edit($id){

        $tratamentosituacao = Tratamentosituacao::findOrFail($id);
        $action             = route('tratamentosituacoesUpdate', array('id' => $tratamentosituacao->id));
        return View::make('tratamentosituacoes.form', compact('tratamentosituacao', 'action'));
    }

    /**
     * Update the specified tratamentosituacao in storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function update($id){

        $model = Tratamentosituacao::findOrFail($id);
        $validator = Validator::make($data = Input::all(), Tratamentosituacao::$rules);
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
     * Remove the specified tratamentosituacao from storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function destroy($id){

        $ts = Tratamentosituacao::findOrFail($id);
        if ($ts->uso_sistema) {
            return Redirect::route('tratamentosituacoes')
                ->with('fail', 'Registro de uso exclusivo do sistema.');
        } else {
            $ts->delete();
            return Redirect::route('tratamentosituacoes')
                ->with('success', 'Registro removido.');
        }
    }
}
