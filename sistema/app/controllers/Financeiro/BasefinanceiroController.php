<?php

class BasefinanceiroController extends \BaseController {

    public function __construct() {
        // User::allowedCredentials(array(10)); Tratado em cada controller
    }

    public function gerarRecibo($id)
    {
        $f = Financeiro::findOrFail($id);
        $recibo = $f->gerarRecibo();
        $s = Sistema::parametros();

        return View::make(
            'financeiro.recibo', compact('recibo', 's')
        );
    }
    
}
