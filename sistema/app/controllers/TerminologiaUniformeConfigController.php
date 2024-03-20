<?php

class TerminologiaUniformeConfigController extends BaseController {

    public function index(){

        $tree = Terminologia::buildUpdateTreeHTML(Terminologia::all()->toArray());
        return View::make('terminologia.index', compact('tree'));
    }

    public function create(){

        $action       = route('terminologiauniformeconfigStore');
        $parents      = Terminologia::where('is_question', '=', '0')->get()->lists('label', 'id');
        $levels       = Terminologia::$levels;
        $is_question  = Terminologia::$isQuestionOptions;

        return View::make('terminologia.create', compact(
            'action', 'levels', 'is_question', 'parents'
        ));
    }

    public function store(){

        $validator = Validator::make($data = Input::all(), Terminologia::$rules);
        if ($validator->fails()){
            return Redirect::route('terminologiauniformeconfig')->withErrors($validator)->withInput();
        }
        Terminologia::create($data);
        Session::put('parent_id', $data['parent_id']);
        Session::put('level', $data['level']);
        return Redirect::route('terminologiauniformeconfig')->with('success', 'Novo item cadastrado.');
    }

    public function edit($id){

        $terminologia = Terminologia::findOrFail($id);
        $action       = route('terminologiauniformeconfigUpdate', array('id' => $terminologia->id));
        $parents      = Terminologia::where('is_question', '=', '0')->get()->lists('label', 'id');
        $levels       = Terminologia::$levels;
        $is_question  = Terminologia::$isQuestionOptions;

        return View::make('terminologia.edit', compact(
            'terminologia', 'action', 'levels', 'is_question', 'parents'
        ));
    }

    public function update($id){

        $terminologia = Terminologia::findOrFail($id);
        $terminologia->update(Input::all());
        return Redirect::route('terminologiauniformeconfig')->with('success', 'Cadastro atualizado.');
    }

    public function destroy($id){

        Terminologia::destroy($id);
        return Redirect::route('terminologiauniformeconfig')->with('success', 'Registro removido.');
    }
}
