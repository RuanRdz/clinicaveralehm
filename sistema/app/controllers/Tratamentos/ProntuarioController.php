<?php

class ProntuarioController extends \BaseController {

    public function __construct() 
    {
        // User::allowedCredentials(array(10, 20));
    }

    /**
     * Listagem geral para impressão
     */
    public function index($paciente_id)
    {
        $paciente = Paciente::findOrFail($paciente_id);
        $prontuario = $paciente->prontuarios()->orderBy('dataprontuario', 'desc')->get();
        return View::make('prontuario.index', compact('paciente', 'prontuario'));
    }

    public function show($id)
    {
        $prontuario = Prontuario::findOrFail($id);
        // User::canChangeRecord($prontuario->terapeuta->id);
        $paciente = $prontuario->paciente;

        $view = 'prontuario.show';
        if(Request::ajax()){
            $view = 'prontuario.show-ajax';
        }

        return View::make($view, compact('paciente', 'prontuario'));
    }

    /**
     * Copia HTML
     * Retorna o HTML puro, para inserir no form do painel
     */
    public function html($id)
    {
        $prontuario = Prontuario::findOrFail($id);

        return $prontuario->descricao;
    }

    public function create($paciente_id, $tratamento_id)
    {
        ### DESABILITADO ###
        ### DIRETO PELO PAINEL ###

        // $paciente = Paciente::findOrFail($paciente_id);
        // $tratamento = Tratamento::findOrFail($tratamento_id);
        // $prontuario = new Prontuario;
        // $prontuario->paciente_id = $paciente->id;
        // $prontuario->tratamento_id = $tratamento_id;
        // if (empty($prontuario->dataprontuario)) {
        //     $prontuario->dataprontuario = date('Y-m-d');
        // }

        // $action = route('prontuarioStore');

        // $view = 'prontuario.form-layout';
        // if(Request::ajax()){
        //     $view = 'prontuario.form-create';
        // }

        // return View::make($view, compact('paciente', 'prontuario', 'action'));
    }

    public function edit($id)
    {
        $prontuario = Prontuario::findOrFail($id);
        User::canChangeRecord($prontuario->terapeuta->id);
        if (! $prontuario->checkTimeLimitToUpdate()) {
            App::abort(401, 'Edição não disponível para este registro');
        }
        $paciente = $prontuario->paciente;

        $action = route('prontuarioUpdate', array('id' => $prontuario->id));
        
        return View::make('prontuario.form-edit', compact('paciente', 'prontuario', 'action'));
    }

    public function store()
    {
        $validator = Validator::make($data = Input::all(), Prontuario::$rules);
        if ($validator->fails()){
            return Redirect::back()->withErrors($validator)->withInput();
        }
        isset($data['alta']) ? $data['alta'] = 1 : $data['alta'] = 0;

        $data['terapeuta_id'] = Auth::user()->id;

        $prontuario = Prontuario::create($data);
        $url = URL::route('painel', array('id' => $prontuario->paciente_id, 'id2' => $prontuario->tratamento_id)).'#tab-prontuario';
        return Redirect::to($url)->with('success', 'Cadastro finalizado.');
    }

    public function update($id)
    {
        $prontuario = Prontuario::findOrFail($id);
     
        if (! $prontuario->checkTimeLimitToUpdate()) {
            App::abort(401, 'Edição não disponível para este registro');
        }

        $validator = Validator::make($data = Input::all(), Prontuario::$rules);
        if ($validator->fails()){
            return Redirect::back()->withErrors($validator)->withInput();
        }

        isset($data['alta']) ? $data['alta'] = 1 : $data['alta'] = 0;

        $data['terapeuta_id'] = Auth::user()->id;

        $prontuario->update($data);

        $url = URL::route('painel', array('id' => $prontuario->paciente_id, 'id2' => $prontuario->tratamento_id)).'#tab-prontuario';
        return Redirect::to($url)->with('success', 'Cadastro atualizado.');
    }

    public function destroy($id)
    {
        User::allowedCredentials(array(10));
        $prontuario = Prontuario::findOrFail($id);

        if (! $prontuario->checkTimeLimitToUpdate()) {
            App::abort(401, 'Exclusão não disponível para este registro');
        }

        User::canChangeRecord($prontuario->terapeuta->id);
        $paciente_id = $prontuario->paciente_id;
        $tratamento_id = $prontuario->tratamento_id;
        $prontuario->delete();
        $url = URL::route('painel', array('id' => $paciente_id, 'id2' => $tratamento_id)).'#tab-prontuario';
        return Redirect::to($url)->with('success', 'Registro removido.');
    }
}
