<?php

class SaldoController extends BasefinanceiroController {

    public function __construct() {
        User::allowedCredentials(array(10));
    }

    /**
     * Listagem Extrato fluxo de caixa
     * @return [type] [description]
     */
    public function index() {

        if (Request::isMethod('post')) {
            Session::put('filtro_saldo', Input::all());
        }

        $opcoes_mensal = Saldo::opcoesMensal();
        $opcoes_anual = Saldo::opcoesAnual();
        $contas = Conta::get();

        $hide_mensal = $hide_anual = '';
        switch (Session::get('filtro_saldo.visao')) {
            case 'mensal':
                $ano = Session::get('filtro_saldo.periodo_anos') ? Session::get('filtro_saldo.periodo_anos') : date('Y');
                $dados = Saldo::demonstrativoMensal($ano);
                $hide_mensal = 'hide';
                break;            
            case 'diario':
            default:
                $d = explode('/', Session::get('filtro_saldo.periodo_meses'));
                if (!empty($d)) {
                    $mes = $d[0];
                    $ano = $d[1];
                } else {
                    $mes = date('m');
                    $ano = date('Y');
                }
                $dados = Saldo::demonstrativoDiario($mes, $ano);
                $hide_anual = 'hide';
                break;
        }

        return View::make('financeiro.saldo', compact([
            'dados', 'contas',
            'opcoes_mensal', 'opcoes_anual',
            'hide_mensal', 'hide_anual'
        ]));
    }

    /**
     * Calcula o saldos diários a parir do saldo inicial
     * TODO EXECUTAR NO CRON
     */
    public function processar() 
    {
        $contas = Conta::get();
        DB::table('saldo')->truncate();
        foreach ($contas as $conta) {
            Financeiro::processaSaldoConta($conta->id);
        }
		return Redirect::route('financeiroSaldo');
    }

    public function excel() {

        // Saldo::saldoExcel(); // TODO
    }
}
