<?php

use app\models\Protocols\Speciality;

/* Painel geral do paciente */

class PainelController extends \BaseController {

    public function __construct() 
    {
        // User::allowedCredentials(array(10, 20, 30));
    }

    public function index($id, $id2 = null)
    {
        $paciente = Paciente::with(
                'prontuarios',
                'tratamentos',
                'tratamentos.tratamentonotificacoes', 
                'tratamentos.paciente.complexidadepacientes',
                'tratamentos.paciente.complexidadepacientes.complexidade',
                'tratamentos.amplitudetratamento',
                'tratamentos.tabelaforca',
                'tratamentos.testeforcatratamento',
                'tratamentos.terminologiatratamento',
                'tratamentos.anamnesetratamento' 
            )    
            ->findOrFail($id);

        $listagemTratamentos = $paciente->tratamentos()->orderBy('created_at', 'DESC')->get();
        if ($id2) {
            $tratamento = $paciente->tratamentos()->findOrFail($id2);
        } else {
            $tratamento = $paciente->tratamentos()->orderBy('created_at', 'DESC')->first();
        }

        $prontuario = $paciente->prontuarios()->orderBy('dataprontuario', 'desc')->get();
        $complexidades = Complexidade::selectBox();
        $menuProtocols = Speciality::menu();
        $faturamento = $tratamento ? $tratamento->dadosFaturamento() : (new Tratamento)->dadosFaturamento();
        if (isset($tratamento->id)) {
            $datasUltimasAvaliacoes = $tratamento->dataUltimasAvaliacoes();
            $lancamentosPaciente = $tratamento->financeiro()->with(['conta', 'formapagamento', 'documento'])->get();
            $idUltimaSessao = $tratamento->obterIdUltimaSessao();
            $sessoes = $tratamento->agendas()->orderBy('sessao')->get();
            $allowAddSessao = false;
            if ($tratamento->convenio) {
                if (count($sessoes) < $tratamento->convenio->limite_sessoes) {
                    $allowAddSessao = true;
                }
            }
            $numSessoesDisponiveis = $tratamento->getNumSessoesDisponiveis();
        } else {
            $datasUltimasAvaliacoes = array();
            $lancamentosPaciente = [];
            $sessoes = [];
            $idUltimaSessao = null;
            $allowAddSessao = false;
            $numSessoesDisponiveis = 0;
        }

        $dados = compact(
            'paciente', 
            'tratamento', 'listagemTratamentos',
            'prontuario', 'complexidades',
            'menuProtocols', 'faturamento',
            'datasUltimasAvaliacoes', 
            'sessoes', 'allowAddSessao', 'idUltimaSessao', 'numSessoesDisponiveis',
            'lancamentosPaciente'
        );

        return View::make('painel.index', $dados);
    }

}
