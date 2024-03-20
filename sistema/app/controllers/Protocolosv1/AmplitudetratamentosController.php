<?php

class AmplitudetratamentosController extends BaseRelatorioController {

    /**
     * @param  [type] $id tratamento_id
     */
    public function index($id)
    {
        $t = Tratamento::findOrFail($id);
        $amplitudetratamentos = Amplitudetratamento::listagem($t);
        $atLados = Amplitudetratamento::$lados;
        return View::make('protocolos.amplitudetratamentos.index', compact(
            'amplitudetratamentos', 'atLados', 't'
        ));
    }

    public function create($id){

        $amplitudetratamento = new Amplitudetratamento;
        $atLados             = Amplitudetratamento::$lados;
        $amplitudeSelectbox  = Amplitude::selectBox();
        $action              = route('amplitudetratamentosStore');
        $rules               = Amplitudetratamento::$rules;
        $t                   = Tratamento::findOrFail($id);
        return View::make(
            'protocolos.amplitudetratamentos.form',
            compact(
                'amplitudetratamento', 'amplitudeSelectbox', 'atLados',
                'action', 'rules', 't'
            )
        );
    }

    public function store(){

        $validator = Validator::make($data = Input::all(), Amplitudetratamento::$rules);
        if ($validator->fails()){
            return Redirect::back()->withErrors($validator)->withInput();
        }
        $amplitudetratamento = Amplitudetratamento::create($data);
        // $amplitudetratamento->tratamento->touch();
        $amplitudetratamento->tratamento->setFezAvaliacao();
        return Redirect::route('amplitudetratamentosIndex', ['id' => $amplitudetratamento->tratamento->id])
            ->with('success', 'Cadastro finalizado.');

    }

    public function edit($id){

        $amplitudetratamento = Amplitudetratamento::findOrFail($id);
        $atLados             = Amplitudetratamento::$lados;
        $amplitudeSelectbox  = Amplitude::selectBox();
        $action              = route('amplitudetratamentosUpdate', array('id' => $amplitudetratamento->id));
        $rules               = Amplitudetratamento::$rules;
        $t                   = Tratamento::findOrFail($amplitudetratamento->tratamento_id);
        return View::make(
            'protocolos.amplitudetratamentos.form',
            compact(
                'amplitudetratamento', 'amplitudeSelectbox', 'atLados',
                'action', 'rules', 't'
            )
        );
    }

    public function update($id){

        $amplitudetratamento = Amplitudetratamento::findOrFail($id);
        $validator           = Validator::make($data = Input::all(), Amplitudetratamento::$rules);
        if ($validator->fails()){
            return Redirect::back()->withErrors($validator)->withInput();
        }
        $amplitudetratamento->update($data);
        $amplitudetratamento->tratamento->touch();
        return Redirect::route('amplitudetratamentosIndex', ['id' => $amplitudetratamento->tratamento->id])
            ->with('success', 'Cadastro atualizado.');
    }

    public function destroy($id){

        $amplitudetratamento = Amplitudetratamento::findOrFail($id);
        $amplitudetratamento->tratamento->touch();
        $amplitudetratamento->delete();
        return Redirect::back()->with('success', 'Registro removido.');
    }
}
