<?php

class TabelaforcaController extends BaseRelatorioController {

    /**
     * @param  [type] $id tratamento_id
     */
    public function index($id)
    {
        $t           = Tratamento::findOrFail($id);
        $tabelaforca = Tabelaforca::listagem($t);
        return View::make('protocolos.tabelaforca.index', compact('tabelaforca', 't'));
    }

    /**
     * @param  [type] $id tratamento_id
     */
    public function create($id){

        $tabelaforca = new Tabelaforca;
        $action      = route('tabelaforcaStore');
        $rules       = Tabelaforca::$rules;
        $t           = Tratamento::findOrFail($id);
        return View::make('protocolos.tabelaforca.form', compact('tabelaforca', 'action', 'rules', 't'));
    }

    public function store(){

        $validator = Validator::make($data = Input::all(), Tabelaforca::$rules);
        if ($validator->fails()){
            return Redirect::back()->withErrors($validator)->withInput();
        }
        $tabelaforca = Tabelaforca::create($data);
        // $tabelaforca->tratamento->touch();
        $tabelaforca->tratamento->setFezAvaliacao();
        return Redirect::route('tabelaforcaIndex', ['id' => $tabelaforca->tratamento->id])
            ->with('success', 'Cadastro finalizado.');

    }

    public function edit($id){
        $tabelaforca = Tabelaforca::findOrFail($id);
        $action      = route('tabelaforcaUpdate', array('id' => $tabelaforca->id));
        $rules       = Tabelaforca::$rules;
        $t           = Tratamento::findOrFail($tabelaforca->tratamento_id);
        return View::make('protocolos.tabelaforca.form', compact('tabelaforca', 'action', 'rules', 't'));
    }

    public function update($id){

        $tabelaforca = Tabelaforca::findOrFail($id);
        $validator   = Validator::make($data = Input::all(), Tabelaforca::$rules);
        if ($validator->fails()){
            return Redirect::back()->withErrors($validator)->withInput();
        }
        $tabelaforca->update($data);
        $tabelaforca->tratamento->touch();
        return Redirect::route('tabelaforcaIndex', ['id' => $tabelaforca->tratamento->id])
            ->with('success', 'Cadastro atualizado.');
    }

    public function destroy($id){

        $tabelaforca = Tabelaforca::findOrFail($id);
        $tabelaforca->tratamento->touch();
        $tabelaforca->delete();
        return Redirect::back()->with('success', 'Registro removido.');
    }
}
