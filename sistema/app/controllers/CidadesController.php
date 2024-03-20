<?php

class CidadesController extends BaseController {

    /**
     * Display a listing of cities
     *
     * @return Response
     */
    public function index(){

        $cidades = Cidade::orderby('pais')
            ->orderby('estado')
            ->orderby('nome')
            ->paginate(50);
        return View::make('cidades.index', compact('cidades'));
    }

    /**
     * Show the form for creating a new city
     *
     * @return Response
     */
    public function create(){

        $cidade  = new Cidade;
        $action = route('cidadesStore');
        return View::make('cidades.form', compact('cidade', 'action'));
    }

    /**
     * Store a newly created city in storage.
     *
     * @return Response
     */
    public function store(){

        $validator = Validator::make($data = Input::all(), Cidade::$rules);
        if ($validator->fails()){
            return Response::json([
                'status' => 'error', 
                'message' => 'Erro de validação. Informe os campos requeridos.', 
                'errors' => $validator->errors()
            ], 422);
        }
        $data['slug'] = $data['nome'];
        $model = Cidade::create($data);
        return Response::json([
            'status' => 'success', 
            'message' => 'Cadastro finalizado.',
            'model' => $model
        ], 200);
    }

    /**
     * Show the form for editing the specified city.
     *
     * @param  int  $id
     * @return Response
     */
    public function edit($id){

        $cidade  = Cidade::findOrFail($id);
        $action = route('cidadesUpdate', array('id' => $cidade->id));
        return View::make('cidades.form', compact('cidade', 'action'));
    }

    /**
     * Update the specified city in storage.
     *
     * @param int $id
     * @return Response
     */
    public function update($id){

        $model = Cidade::findOrFail($id);
        $validator = Validator::make($data = Input::all(), Cidade::$rules);
        if ($validator->fails()){
            return Response::json([
                'status' => 'error', 
                'message' => 'Erro de validação. Informe os campos requeridos.', 
                'errors' => $validator->errors()
            ], 422);
        }
        $data['slug'] = $data['nome'];
        $model->update($data);
        return Response::json([
            'status' => 'success', 
            'message' => 'Cadastro atualizado.',
            'model' => $model
        ], 200);
    }

    /**
     * Remove the specified city from storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function destroy($id){

        Cidade::destroy($id);
        return Redirect::back()->with('success', 'Registro removido.');
    }
}
