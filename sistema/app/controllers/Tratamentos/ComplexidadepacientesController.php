<?php

class ComplexidadepacientesController extends \BaseController {

    public function __construct() 
    {
        User::allowedCredentials(array(10, 20));
    }

    public function store()
    {
        $validator = Validator::make($data = Input::all(), Complexidadepaciente::$rules);
        if ($validator->fails()){
            return Redirect::back()->withErrors($validator)->withInput();
        }
        Complexidadepaciente::create($data);
        return Redirect::back()->with('success', 'Registro cadastrado.');
    }

    public function destroy($id)
    {
        $complexidade = Complexidadepaciente::findOrFail($id);
        User::canChangeRecord($complexidade->createdBy->id);
        $paciente_id = $complexidade->paciente_id;
        $complexidade->delete();
        return Redirect::route('painel', array('paciente_id' => $paciente_id))
            ->with('success', 'Registro removido.');
    }
}
