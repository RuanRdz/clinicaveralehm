<?php

class TesteforcatratamentosController extends BaseRelatorioController {

    /**
     * @param  [type] $id tratamento_id
     */
    public function index($id)
    {
        $t = Tratamento::findOrFail($id);
        $testeforcatratamentos = Testeforcatratamento::listagem($t);
        $tfCategorias = Testeforca::$categorias;
        return View::make('protocolos.testeforcatratamento.index', compact(
            'testeforcatratamentos', 'tfCategorias', 't'
        ));
    }

    public function create($id){

        $testeforcatratamento = new Testeforcatratamento;
        $graus                = Testeforcatratamento::$graus;
        $action               = route('testeforcatratamentosStore');
        $rules                = Testeforcatratamento::$rules;
        $t                    = Tratamento::findOrFail($id);
        $testeforca_nome      = '';
        return View::make(
            'protocolos.testeforcatratamento.form',
            compact(
                'testeforcatratamento', 'graus',
                'action', 'rules', 't', 'testeforca_nome'
            )
        );
    }

    public function store(){

        $validator = Validator::make($data = Input::all(), Testeforcatratamento::$rules);
        if ($validator->fails()){
            return Redirect::back()->withErrors($validator)->withInput();
        }
        $testeforcatratamento = Testeforcatratamento::create($data);
        // $testeforcatratamento->tratamento->touch();
        $testeforcatratamento->tratamento->setFezAvaliacao();
        return Redirect::route('testeforcatratamentosIndex', ['id' => $testeforcatratamento->tratamento->id])
            ->with('success', 'Cadastro finalizado.');

    }

    public function edit($id){

        $testeforcatratamento = Testeforcatratamento::findOrFail($id);
        $graus                = Testeforcatratamento::$graus;
        $action               = route('testeforcatratamentosUpdate', array('id' => $testeforcatratamento->id));
        $rules                = Testeforcatratamento::$rules;
        $t                    = Tratamento::findOrFail($testeforcatratamento->tratamento_id);
        $testeforca_nome      = $testeforcatratamento->testeforca->nome;
        return View::make(
            'protocolos.testeforcatratamento.form',
            compact(
                'testeforcatratamento', 'graus',
                'action', 'rules', 't', 'testeforca_nome'
            )
        );
    }

    public function update($id){

        $testeforcatratamento = Testeforcatratamento::findOrFail($id);
        $validator            = Validator::make($data = Input::all(), Testeforcatratamento::$rules);
        if ($validator->fails()){
            return Redirect::back()->withErrors($validator)->withInput();
        }
        $testeforcatratamento->update($data);
        $testeforcatratamento->tratamento->touch();
        return Redirect::route('testeforcatratamentosIndex', ['id' => $testeforcatratamento->tratamento->id])
            ->with('success', 'Cadastro atualizado.');
    }

    public function destroy($id){

        $testeforcatratamento = Testeforcatratamento::findOrFail($id);
        $testeforcatratamento->tratamento->touch();
        $testeforcatratamento->delete();
        return Redirect::back()->with('success', 'Registro removido.');
    }
}
