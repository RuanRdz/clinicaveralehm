<?php

class WorkspacesController extends BaseController {

    /**
     * Display a listing of workspaces
     *
     * @return Response
     */
    public function index()
    {
        $workspaces = Workspace::all();
        return View::make('workspaces.index', compact('workspaces'));
    }

    /**
     * Show the form for creating a new workspace
     *
     * @return Response
     */
    public function create()
    {
        $workspace        = new Workspace;
        $action           = route('workspacesStore');
        $workspace_cidade = '';
        $users            = User::todos();
        return View::make('workspaces.form', compact('workspace', 'workspace_cidade', 'action', 'users'));
    }

    /**
     * Store a newly created workspace in storage.
     *
     * @return Response
     */
    public function store()
    {
        $validator = Validator::make($data = Input::all(), Workspace::$rules);
        if ($validator->fails()) {
            return Response::json([
                'status' => 'error', 
                'message' => 'Erro de validação. Informe os campos requeridos.', 
                'errors' => $validator->errors()
            ], 422);
        }
        $model = Workspace::create($data);
        $model->users()->sync($data['user_workspace']);
        return Response::json([
            'status' => 'success', 
            'message' => 'Cadastro finalizado.',
            'model' => $model
        ], 200);
    }

    /**
     * Show the form for editing the specified workspace.
     *
     * @param  int  $id
     * @return Response
     */
    public function edit($id)
    {
        $workspace        = Workspace::findOrFail($id);
        $workspace_cidade = $workspace->cidade_id ? $workspace->cidade->nome.' - '.$workspace->cidade->estado_uf : '';
        $action           = route('workspacesUpdate', array('id' => $workspace->id));
        $users            = User::todos();
        $user_workspace   = $workspace->users->lists('fullName', 'id');
        $dados            = compact(
            'workspace', 'workspace_cidade',
            'action', 'users', 'user_workspace'
        );
        return View::make('workspaces.form', $dados);
    }

    /**
     * Update the specified workspace in storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function update($id)
    {
        $model = Workspace::findOrFail($id);
        $data      = Input::all();
        $validator = Validator::make($data, Workspace::$rules);
        if ($validator->fails()){
            return Response::json([
                'status' => 'error', 
                'message' => 'Erro de validação. Informe os campos requeridos.', 
                'errors' => $validator->errors()
            ], 422);
        }
        $model->update($data);
        if (!isset($data['user_workspace'])) {
            $data['user_workspace'] = [];
        }
        $model->users()->sync($data['user_workspace']);
        return Response::json([
            'status' => 'success', 
            'message' => 'Cadastro atualizado.',
            'model' => $model
        ], 200);
    }

    /**
     * Remove the specified workspace from storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function destroy($id)
    {
        $workspace = Workspace::findOrFail($id);
        if (count($workspace->tratamentos) > 0) {
            return Redirect::route('workspaces')
                ->with('success', 'Não é possível remover Áreas de trabalho que contém Tratamentos vinculados.');
        }
        $workspace->delete();
        return Redirect::route('workspaces')
            ->with('success', 'Área de trabalho removida.');
    }

    /**
     * Altera a sessão para definir a área de trabalho
     */
    public function setCurrent($id)
    {
        $workspace = Workspace::findOrFail($id);

        Session::put('filtro.terapeuta_id', null);
        Session::forget('workspace_id');
        Session::forget('workspace_nome');
        Session::put('workspace_id', $workspace->id);
        Session::put('workspace_nome', $workspace->nome);
        return Redirect::back()->with('success', 'Área de Trabalho atualizada.');
    }

}
