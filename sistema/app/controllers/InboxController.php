<?php

class InboxController extends \BaseController {

	/**
	 * Display a listing of the resource.
	 * GET /inbox
	 *
	 * @return Response
	 */
	public function index($id = null)
	{
		$para = User::find($id);
		$usuarios = User::todosInbox();
		$prioridade = Tarefa::$optionsPrioridade;
		$action = route('inboxStore');

		$inbox = array();
		if (null != $para) {
			$inbox = Tarefa::inbox($para);
		}

		return View::make('inbox.index', compact(
			'para', 'usuarios', 'prioridade', 'inbox', 'action'
		));
	}

	/**
	 * Store a newly created resource in storage.
	 * POST /inbox
	 *
	 * @return Response
	 */
	public function store()
	{
		$validator = Validator::make($data = Input::all(), Tarefa::$rules);
        if ($validator->fails()){
            return Redirect::back()->withErrors($validator)->withInput();
        }
        Tarefa::create($data);
        return Redirect::back();
	}

	public function visualizado($id, $letra) {

        $tarefa = Tarefa::with('para')->findOrFail($id);
        User::canChangeRecord($tarefa->para->id);
        $tarefa->visualizado = $letra;
        $tarefa->save();
        return Redirect::back();
    }

    public function situacao($id, $opcao) {

        $tarefa = Tarefa::with('para')->findOrFail($id);
        User::canChangeRecord($tarefa->para->id);
        $tarefa->situacao = $opcao;
        $tarefa->save();
        return Redirect::back();
    }
}
