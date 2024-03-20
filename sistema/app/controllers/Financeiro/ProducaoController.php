<?php

class ProducaoController extends BasefinanceiroController {

    public function __construct() {
        User::allowedCredentials(array(10));
    }

    public function index() 
    {
        $resultado = [
            't_valor' => 0,
            't_valor_pago' => 0,
            't_valor_comissao' => 0,
            'dados' => []
        ];

        $profissionais = array('' => '');
        if (Session::get('workspace_id')) {
            $profissionais = array('' => '') + Workspace::terapeutas(Session::get('workspace_id'))->lists('fullName', 'id');
        }

        $filtro = [
            'profissionais' => $profissionais,
            'meses' => $this->opcoesMeses(),
            'anos' => $this->opcoesAnos(),
            'comissoes' => $this->opcoesComissoes()
        ];

        if (Request::isMethod('post')) {
            $params = Input::all();
            $params = [
                'profissional' => Input::get('profissional', ''),
                'mes' => Input::get('mes', date('m')),
                'ano' => Input::get('ano', date('Y')),
                'comissao' => Input::get('comissao', '0.4'),
            ];
            Session::put('filtro_producao', $params);
            $resultado = Financeiro::producao($params);
        } else {
            $params = [
                'profissional' => '',
                'mes' => date('m'),
                'ano' => date('Y'),
                'comissao' => '0.4',
            ];
            Session::put('filtro_producao', $params);
        }

        return View::make('financeiro.producao', compact('resultado', 'filtro', 'params'));
    }

    private function opcoesAnos() 
    {
        $start = date('Y', strtotime('-2 years'));
        $end = date('Y', strtotime('+1 years'));
        $years = [];
        foreach (range($start, $end) as $year) {
            $years[$year] = $year;
        }
        return $years;
    }

    private function opcoesMeses()
    {
        return [
            '01' => 'Janeiro',
            '02' => 'Fevereiro',
            '03' => 'Março',
            '04' => 'Abril',
            '05' => 'Maio',
            '06' => 'Junho',
            '07' => 'Julho',
            '08' => 'Agosto',
            '09' => 'Setembro',
            '10' => 'Outubro',
            '11' => 'Novembro',
            '12' => 'Dezembro',
        ];
    }

    private function opcoesComissoes()
    {
        return [
            '' => '',
            '0.1' => '10%',
            '0.2' => '20%',
            '0.3' => '30%',
            '0.4' => '40%',
            '0.5' => '50%',
            '0.6' => '60%',
            '0.7' => '70%',
            '0.8' => '80%',
            '0.9' => '90%',
            '1' =>'100%',
        ];
    }
}
