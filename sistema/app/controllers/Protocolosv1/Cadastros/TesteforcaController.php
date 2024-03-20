<?php

class TesteforcaController extends \BaseController {

    public function __construct() {

        User::allowedCredentials(array(10));
    }

    public function create(){

        $testeforca = new Testeforca;
        $action     = route('testeforcaStore');
        $rules      = Testeforca::$rules;
        $categorias = Testeforca::$categorias;
        return View::make(
            'protocolos.testeforca.form',
            compact('testeforca', 'action', 'rules', 'categorias')
        );
    }

    public function store(){

        $validator = Validator::make($data = Input::all(), Testeforca::$rules);
        if ($validator->fails()){
            return Redirect::back()->withErrors($validator)->withInput();
        }
        Testeforca::create($data);
        return Redirect::route('anamneseShow', array('bloco' => 'testeforca'))
            ->with('success', 'Cadastro finalizado.');
    }

    public function edit($id){

        $testeforca = Testeforca::findOrFail($id);
        $action     = route('testeforcaUpdate', array('id' => $testeforca->id));
        $rules      = Testeforca::$rules;
        $categorias = Testeforca::$categorias;
        return View::make(
            'protocolos.testeforca.form',
            compact('testeforca', 'action', 'rules', 'categorias')
        );
    }

    public function update($id){

        $testeforca = Testeforca::findOrFail($id);
        $validator  = Validator::make($data = Input::all(), Testeforca::$rules);
        if ($validator->fails()){
            return Redirect::back()->withErrors($validator)->withInput();
        }
        $testeforca->update($data);
        return Redirect::route('anamneseShow', array('bloco' => 'testeforca'))
            ->with('success', 'Cadastro atualizado.');
    }

    public function destroy($id){

        $testeforca = Testeforca::findOrFail($id);
        $testeforca->delete();
        $link_restore = link_to_route('testeforcaRestore', 'DESFAZER ?', array('id' => $testeforca->id));
        return Redirect::route('anamneseShow', array('bloco' => 'testeforca'))
            ->with('success', 'Registro removido. ('.$link_restore.')');
    }

    public function restore($id){

        $testeforca = Testeforca::withTrashed()->findOrFail($id);
        $testeforca->restore();
        return Redirect::route('anamneseShow', array('bloco' => 'testeforca'))
            ->with('success', 'Registro restaurado.');
    }
}
