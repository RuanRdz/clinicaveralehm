<?php

class FluxoController extends BasefinanceiroController {

    public function __construct() {
        User::allowedCredentials(array(10));
    }

    /**
     * Listagem Fluxo de caixa
     * @return [type] [description]
     */
    public function index() {

        if (Request::isMethod('post')) {
            Session::put('filtro_financeiro', Input::all());
        } else {
            Session::forget('filtro_financeiro');
        }
        
        $filtroOptions = Financeiro::filtroOptions();
        $ano = date('Y');

        $dados = Cache::remember('dados_fluxodecaixa', 3, function() use ($ano) {
            return [
                'centrocusto' => Financeiro::fluxoDeCaixa('centrocusto', $ano),
                'documento' => Financeiro::fluxoDeCaixa('documento', $ano),
                'formapagamento' => Financeiro::fluxoDeCaixa('formapagamento', $ano),
                'tipodespesa' => Financeiro::fluxoDeCaixa('tipodespesa', $ano),
            ];
        });

        return View::make('financeiro.fluxo', compact(array('filtroOptions', 'dados')));
    }

    public function excel() {

        Financeiro::fluxoExcel();
    }
}
