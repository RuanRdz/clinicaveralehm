<?php

class FornecedoresController extends BasefinanceiroController {

    /**
     * Display a listing of fornecedores
     *
     * @return Response
     */
    public function index(){

        $current_char = Input::get('char', 'A');
        $fornecedores = Fornecedor::orderby('nome')
            ->where(function ($query) use ($current_char) {
                if ($current_char == 'number') {
                    foreach (range(0, 9) as $number) {
                        $query->orWhere('nome', 'like', "$number%");
                        $query->orWhere('razao_social', 'like', "$number%");
                    }    
                } else {
                    $query->where('nome', 'like', "$current_char%");
                    $query->orWhere('razao_social', 'like', "$current_char%");
                }
            })
            ->paginate(100);

        return View::make('fornecedores.index', compact(['fornecedores', 'current_char']));
    }

    /**
     * Show the form for creating a new fornecedor
     *
     * @return Response
     */
    public function create(){

        $fornecedor = new Fornecedor;
        $fornecedor_cidade = '';
        $action = route('fornecedoresStore');
        return View::make('fornecedores.form', compact('fornecedor', 'fornecedor_cidade', 'action'))
            ->nest('button_fk_cidade', 'layouts.admin.add-button-fk', [
                'url' => route('cidadesCreate'), 
                'seletor' => '#cidade_id'
            ]);
    }

    /**
     * Store a newly created fornecedor in storage.
     *
     * @return Response
     */
    public function store(){

        $validator = Validator::make($data = Input::all(), Fornecedor::$rules);
        if ($validator->fails()) {
            return Response::json([
                'status' => 'error', 
                'message' => 'Erro de validação. Informe os campos requeridos.', 
                'errors' => $validator->errors()
            ], 422);
        }
        $model = Fornecedor::create($data);
        return Response::json([
            'status' => 'success', 
            'message' => 'Cadastro finalizado.',
            'model' => $model
        ], 200);
    }

    /**
     * Show the form for editing the specified fornecedor.
     *
     * @param  int  $id
     * @return Response
     */
    public function edit($id){

        $fornecedor = Fornecedor::findOrFail($id);
        !is_null($fornecedor->cidade)
            ? $fornecedor_cidade = $fornecedor->cidade->nome.' - '.$fornecedor->cidade->estado_uf
            : $fornecedor_cidade = null;
        $action = route('fornecedoresUpdate', array('id' => $fornecedor->id));
        return View::make('fornecedores.form', compact('fornecedor', 'fornecedor_cidade', 'action'));
    }

    /**
     * Update the specified fornecedor in storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function update($id){

        $model = Fornecedor::findOrFail($id);

        $rules                       = Fornecedor::$rules;
        $rules['cnpj']               = $rules['cnpj'].','.$model->id;
        $rules['cpf']                = $rules['cpf'].','.$model->id;
        $rules['inscricao_estadual'] = $rules['inscricao_estadual'].','.$model->id;

        $validator = Validator::make($data = Input::all(), $rules);
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
     * Remove the specified fornecedor from storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function destroy($id){

        Fornecedor::destroy($id);
        return Redirect::back()->with('success', 'Registro removido.');
    }
}
