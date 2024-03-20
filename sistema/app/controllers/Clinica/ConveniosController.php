<?php

class ConveniosController extends \BaseController {

    /**
     * Display a listing of convenios
     *
     * @return Response
     */
    public function index(){

        User::allowedCredentials(array(10));
        $convenios = Convenio::with('cidade', 'conveniotipo')->orderby('nome')->paginate(50);
        return View::make('convenios.index', compact('convenios'));
    }

    /**
     * Show the form for creating a new convenio
     *
     * @return Response
     */
    public function create(){

        User::allowedCredentials(array(10));
        $convenio        = new Convenio;
        $tipos           = Conveniotipo::all()->toArray('id', 'nome');
        $action          = route('conveniosStore');
        $convenio_cidade = '';
        return View::make('convenios.form', compact('convenio', 'convenio_cidade', 'tipos', 'action'))
            ->nest('button_fk_conveniostipo', 'layouts.admin.add-button-fk', [
                'url' => route('conveniotiposCreate'), 
                'seletor' => '#conveniotipo_id'
            ])
            ->nest('button_fk_cidade', 'layouts.admin.add-button-fk', [
                'url' => route('cidadesCreate'), 
                'seletor' => '#cidade_id'
            ]);
    }

    /**
     * Store a newly created convenio in storage.
     *
     * @return Response
     */
    public function store(){

        User::allowedCredentials(array(10));
        $validator = Validator::make($data = Input::all(), Convenio::$rules);
        if ($validator->fails()) {
            return Response::json([
                'status' => 'error', 
                'message' => 'Erro de validação. Informe os campos requeridos.', 
                'errors' => $validator->errors()
            ], 422);
        }
        $model = Convenio::create($data);
        return Response::json([
            'status' => 'success', 
            'message' => 'Cadastro finalizado.',
            'model' => $model
        ], 200);
    }

    /**
     * Show the form for editing the specified convenio.
     *
     * @param  int  $id
     * @return Response
     */
    public function edit($id){

        User::allowedCredentials(array(10));
        $convenio        = Convenio::findOrFail($id);
        $tipos           = Conveniotipo::all()->toArray('id', 'nome');
        $convenio_cidade = $convenio->cidade_id ? $convenio->cidade->nome.' - '.$convenio->cidade->estado_uf : '';
        $action          = route('conveniosUpdate', array('id' => $convenio->id));
        return View::make('convenios.form', compact('convenio', 'convenio_cidade', 'tipos', 'action'))
            ->nest('button_fk_conveniostipo', 'layouts.admin.add-button-fk', [
                'url' => route('conveniotiposCreate'), 
                'seletor' => '#conveniotipo_id'
            ])->nest('button_fk_cidade', 'layouts.admin.add-button-fk', [
                'url' => route('cidadesCreate'), 
                'seletor' => '#cidade_id'
            ]);
    }

    /**
     * Update the specified convenio in storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function update($id){

        User::allowedCredentials(array(10));
        $model = Convenio::findOrFail($id);
        $validator = Validator::make($data = Input::all(), Convenio::$rules);
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
     * Remove the specified convenio from storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function destroy($id){

        User::allowedCredentials(array(10));
        Convenio::destroy($id);
        return Redirect::back()->with('success', 'Registro removido.');
    }
}
