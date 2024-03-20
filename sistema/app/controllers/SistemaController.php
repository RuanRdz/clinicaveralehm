<?php

class SistemaController extends BaseController {

    public function __construct() {

        User::allowedCredentials(array(10, 20));
    }

    public function index() {

        $sistema = Sistema::get();
        return View::make('sistema.index', compact('sistema'));
    }

    public function update() {

        $post = Input::all();
        foreach ($post as $id => $descricao) {
            if (is_numeric($id)) {
                $s = Sistema::find($id);
                if ($s->id) {
                    $s->descricao = $descricao;
                    $s->save();
                }
            }
        }
        return Redirect::route('sistema')
            ->with('success', 'Cadastro atualizado.');
    }
}
