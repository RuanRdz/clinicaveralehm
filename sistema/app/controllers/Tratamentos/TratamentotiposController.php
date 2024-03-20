<?php

class TratamentotiposController extends \BaseController {

    public function __construct() {

        User::allowedCredentials(array(10));
    }

    /**
     * Display a listing of tratamentotipos
     *
     * @return Response
     */
    public function index(){

        // $tratamentotipos = Tratamentotipo::all();
        $tratamentotipos = Tratamentotipo::orderby('sequencia')->get();
        return View::make('tratamentotipos.index', compact('tratamentotipos'));
    }

    /**
     * Show the form for creating a new tratamentotipo
     *
     * @return Response
     */
    public function create(){

        $tratamentotipo = new Tratamentotipo;
        $action         = route('tratamentotiposStore');
        return View::make('tratamentotipos.form', compact('tratamentotipo', 'action'));
    }

    /**
     * Store a newly created tratamentotipo in storage.
     *
     * @return Response
     */
    public function store(){

        $validator = Validator::make($data = Input::all(), Tratamentotipo::$rules);
        if ($validator->fails()) {
            return Response::json([
                'status' => 'error', 
                'message' => 'Erro de validação. Informe os campos requeridos.', 
                'errors' => $validator->errors()
            ], 422);
        }
        $model = Tratamentotipo::create($data);
        return Response::json([
            'status' => 'success', 
            'message' => 'Cadastro finalizado.',
            'model' => $model
        ], 200);
    }

    /**
     * Display the specified tratamentotipo.
     *
     * @param  int  $id
     * @return Response
     */
    public function show($id){

        $tratamentotipo = Tratamentotipo::findOrFail($id);
        return View::make('tratamentotipos.show', compact('tratamentotipo'));
    }

    /**
     * Show the form for editing the specified tratamentotipo.
     *
     * @param  int  $id
     * @return Response
     */
    public function edit($id){

        $tratamentotipo = Tratamentotipo::findOrFail($id);
        $action = route('tratamentotiposUpdate', array('id' => $tratamentotipo->id));
        return View::make('tratamentotipos.form', compact('tratamentotipo', 'action'));
    }

    /**
     * Update the specified tratamentotipo in storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function update($id){

        $model = Tratamentotipo::findOrFail($id);
        $validator = Validator::make($data = Input::all(), Tratamentotipo::$rules);
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
     * Remove the specified tratamentotipo from storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function destroy($id){

        Tratamentotipo::destroy($id);
        return Redirect::back()->with('success', 'Registro removido.');
    }
}
