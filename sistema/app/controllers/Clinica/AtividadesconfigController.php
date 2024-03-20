<?php

use Anamnese as Atividadesconfig;

/* 
Gerenciador de parâmetros de atividades 
*/
class AtividadesconfigController extends \BaseController {

    public function __construct() {

        User::allowedCredentials(array(10));
    }

    public function index() {

        $bloco = null;
        $blocos = Atividadesconfig::$blocos;
        return View::make('atividades-config.index', compact('blocos', 'bloco'));
    }

    public function show($bloco) {
        $blocos = Atividadesconfig::$blocos;
        switch ($bloco) {
            // case 'A':
            case 'B':
            case 'C':
            case 'D':
            case 'E':
            case 'F':
            case 'G':
                $descricao = Atividadesconfig::$blocos[$bloco];
                $dados = Atividadesconfig::bloco($bloco);
                $opcoesAtividade = Atividadesconfig::$opcoesAtividade;
                return View::make('atividades-config.bloco', compact(
                    'dados', 'opcoesAtividade', 'descricao', 'bloco', 'blocos'
                ));

            // case 'testeforca':
            //     $testeForca = Testeforca::blocosPorCategoria();
            //     return View::make('protocolos.testeforca.index', compact('testeForca'));

            // case 'amplitude':
            //     $amplitude = Amplitude::blocosPorGrupo();
            //     return View::make('protocolos.amplitudes.index', compact('amplitude'));
        }
    }

    public function create($letra) {

        $atividade        = new Atividadesconfig;
        $atividade->bloco = $letra;
        $rules           = Atividadesconfig::$rules;
        $blocos          = Atividadesconfig::$blocos;
        $opcoes          = Atividadesconfig::$opcoes;
        $opcoesAtividade = Atividadesconfig::$opcoesAtividade;
        $action          = route('atividadesconfigStore');
        $descricao = Atividadesconfig::$blocos[$atividade->bloco];
        $bloco = $letra;
        return View::make('atividades-config.form', compact(
            'atividade', 'rules', 'action', 'blocos', 'opcoes', 'opcoesAtividade', 'descricao', 'bloco'
        ));
    }

    public function store() {

        $validator = Validator::make($data = Input::all(), Atividadesconfig::$rules);
        if ($validator->fails()) {
            return Redirect::back()->withErrors($validator)->withInput();
        }
        $atividade = Atividadesconfig::create($data);
        return Redirect::route('atividadesconfigShow', array('bloco' => $atividade->bloco))
            ->with('success', 'Cadastro finalizado.');
    }


    public function edit($id){

        $atividade        = Atividadesconfig::findOrFail($id);
        $rules           = Atividadesconfig::$rules;
        $blocos          = Atividadesconfig::$blocos;
        $opcoes          = Atividadesconfig::$opcoes;
        $opcoesAtividade = Atividadesconfig::$opcoesAtividade;
        $action          = route('atividadesconfigUpdate', array('id' => $atividade->id));
        $descricao = Atividadesconfig::$blocos[$atividade->bloco];
        $bloco = $atividade->bloco;
        return View::make('atividades-config.form', compact(
            'atividade', 'rules', 'action', 'blocos', 'opcoes', 'opcoesAtividade', 'descricao', 'bloco'
        ));
    }

    public function update($id) {

        $atividade  = Atividadesconfig::findOrFail($id);
        $validator = Validator::make($data = Input::all(), Atividadesconfig::$rules);
        if ($validator->fails()){
            return Redirect::back()->withErrors($validator)->withInput();
        }
        $atividade->update($data);
        return Redirect::route('atividadesconfigShow', array('bloco' => $atividade->bloco))
            ->with('success', 'Cadastro atualizado.');
    }


    public function destroy($id){

        $atividade = Atividadesconfig::findOrFail($id);
        $bloco = $atividade->bloco;
        $atividade->delete();
        $link_restore = link_to_route('atividadesconfigRestore', 'DESFAZER ?', array('id' => $atividade->id));
        return Redirect::route('atividadesconfigShow', array('bloco' => $bloco))
            ->with('success', 'Registro removido. ('.$link_restore.')');
    }

    public function restore($id){

        $atividade = Atividadesconfig::withTrashed()->findOrFail($id);
        $atividade->restore();
        return Redirect::route('atividadesconfigShow', array('bloco' => $atividade->bloco))
            ->with('success', 'Registro restaurado.');
    }

    public function ordenar() 
    {
        $items = Input::get('items');

        if (count($items) > 0) {
            foreach ($items as $key => $id) {
                $data = Atividadesconfig::findOrFail($id);
                $data->ordem = $key + 1;
                $data->save();
            }
        }

        return json_encode(['status' => 'ok']);
    }
}
