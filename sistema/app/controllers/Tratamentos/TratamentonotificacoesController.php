<?php

class TratamentonotificacoesController extends \BaseController {

    /**
     * Display a listing of tratamentonotificacoes by tratamentos
     *
     * @return Response
     */
    public function index($id){

        $tratamento   = Tratamento::findOrFail($id);
        $notificacoes = Tratamentonotificacao::listagem($id);
        return View::make('tratamentonotificacoes.index', compact('tratamento', 'notificacoes'));
    }

    /**
     * Show the form for creating a new tratamentonotificacao
     *
     * @return Response
     */
    public function create(){

        return View::make('tratamentonotificacoes.create');
    }

    /**
     * Store a newly created tratamentonotificacao in storage.
     *
     * @return Response
     */
    public function store(){

        $validator = Validator::make($data = Input::all(), Tratamentonotificacao::$rules);
        if ($validator->fails()){
            return Redirect::back()->withErrors($validator)->withInput();
        }
        $notificacao = Tratamentonotificacao::create($data);
        return View::make('tratamentonotificacoes.show', compact('notificacao'));
    }

    /**
     * Display the specified tratamentonotificacao.
     *
     * @param  int  $id
     * @return Response
     */
    public function show($id){

        $tratamentonotificacao = Tratamentonotificacao::findOrFail($id);
        return View::make('tratamentonotificacoes.show', compact('tratamentonotificacao'));
    }

    /**
     * Show the form for editing the specified tratamentonotificacao.
     *
     * @param  int  $id
     * @return Response
     */
    public function edit($id){

        $tratamentonotificacao = Tratamentonotificacao::find($id);
        return View::make('tratamentonotificacoes.edit', compact('tratamentonotificacao'));
    }

    /**
     * Update the specified tratamentonotificacao in storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function update($id){

        $tratamentonotificacao = Tratamentonotificacao::findOrFail($id);
        $validator             = Validator::make($data = Input::all(), Tratamentonotificacao::$rules);
        if ($validator->fails()){
            return Redirect::back()->withErrors($validator)->withInput();
        }
        $tratamentonotificacao->update($data);
        return Redirect::route('tratamentonotificacoes.index');
    }

    /**
     * Altera o estado da mensagem [lido / não lido]
     */
    public function alterarEstado($id){

        $tn = Tratamentonotificacao::findOrFail($id);
        switch ($tn->lido) {
            case 'Y': $tn->lido = 'N'; break;
            case 'N': $tn->lido = 'Y'; break;
        }
        $tn->save();
        return 1;
    }

    /**
     * Remove the specified tratamentonotificacao from storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function destroy($id){

        Tratamentonotificacao::destroy($id);
        return 1;
    }

}
