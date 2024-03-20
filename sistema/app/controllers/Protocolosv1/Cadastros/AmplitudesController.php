<?php

class AmplitudesController extends \BaseController {

    public function __construct() {

        User::allowedCredentials(array(10));
    }

    public function create(){

        $amplitude = new Amplitude;
        $action    = route('amplitudesStore');
        $rules     = Amplitude::$rules;
        $grupos    = Amplitudegrupo::lists('nome', 'id');
        return View::make(
            'protocolos.amplitudes.form',
            compact('amplitude', 'action', 'rules', 'grupos')
        );
    }

    public function store(){

        $data = Input::all();
        if (!is_numeric($data['amplitudegrupo_id'])) {
            $ag       = new Amplitudegrupo;
            $ag->nome = $data['amplitudegrupo_id'];
            $ag->save();
            $data['amplitudegrupo_id'] = $ag->id;
        }
        $validator = Validator::make($data, Amplitude::$rules);
        if ($validator->fails()){
            return Redirect::back()->withErrors($validator)->withInput();
        }
        Amplitude::create($data);
        return Redirect::route('anamneseShow', array('bloco' => 'amplitude'))
            ->with('success', 'Cadastro finalizado.');
    }

    public function edit($id){

        $amplitude = Amplitude::findOrFail($id);
        $action    = route('amplitudesUpdate', array('id' => $amplitude->id));
        $rules     = Amplitude::$rules;
        $grupos    = Amplitudegrupo::lists('nome', 'id');
        return View::make(
            'protocolos.amplitudes.form',
            compact('amplitude', 'action', 'rules', 'grupos')
        );
    }

    public function update($id){

        $amplitude = Amplitude::findOrFail($id);
        $validator = Validator::make($data = Input::all(), Amplitude::$rules);
        if ($validator->fails()){
            return Redirect::back()->withErrors($validator)->withInput();
        }
        $amplitude->update($data);
        return Redirect::route('anamneseShow', array('bloco' => 'amplitude'))
            ->with('success', 'Cadastro atualizado.');
    }

    public function destroy($id){

        $amplitude = Amplitude::findOrFail($id);
        $amplitude->delete();
        $link_restore = link_to_route('amplitudesRestore', 'DESFAZER ?', array('id' => $amplitude->id));
        return Redirect::route('anamneseShow', array('bloco' => 'amplitude'))
            ->with('success', 'Registro removido. ('.$link_restore.')');
    }

    public function restore($id){

        $amplitude = Amplitude::withTrashed()->findOrFail($id);
        $amplitude->restore();
        return Redirect::route('anamneseShow', array('bloco' => 'amplitude'))
            ->with('success', 'Registro restaurado.');
    }
}
