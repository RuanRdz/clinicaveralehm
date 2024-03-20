<?php

class Anamnese extends \Eloquent
{
    use SoftDeletingTrait;
    protected $dates = array('deleted_at');

    protected $table = 'anamnese';

    public static $rules = array(
        'nome'  => 'required',
        'opcao' => 'required|in:simples,composta',
        'bloco' => 'required|in:A,B,C,D,E,F',
        'ordem' => 'required|integer',
    );

    protected $fillable = array(
        'nome', 'bloco', 'opcao', 'opcao_atividade', 'ordem',
    );

    public static $blocos = array(
        'A' => 'MAPEAMENTO SENSORIAL / MONOFILAMENTOS',
        'B' => 'REALIZAMOS',
        'C' => 'ATIVIDADES DE AUTO-MANUTENÇÃO E AUTONOMIA',
        // 'D' => 'INFORMAÇÕES COMPLEMENTARES', // DESABILITADO
        'E' => 'O PACIENTE APRESENTOU',
        'F' => 'SUGERIMOS QUANTO AO SEU TRATAMENTO TERAPÊUTICO',
    );

    public static $opcoesControle = array(
        'B'    => 'REALIZAMOS',
        'A'    => 'MAPEAMENTO SENSORIAL / MONOFILAMENTOS',
        'C'    => 'AVD\'s + POSICIONAL AVALIAÇÕES',
        // 'D' => 'INFORMAÇÕES COMPLEMENTARES', // DESABILITADO
        'TF'   => 'TABELA DE FORÇA - JAMAR',
        'TFM'  => 'TESTE DE FORÇA MUSCULAR',
        'AM'   => 'AMPLITUDE DE MOVIMENTO',
        'TU'   => 'TERMINOLOGIA UNIFORME',
        'E'    => 'O PACIENTE APRESENTOU',
        'F'    => 'RETORNE PARA SUA AVALIAÇÃO E CONDUTA...',
    );

    public static $opcoes = array(
        'simples'  => 'Simples',
        'composta' => 'Opção + Campo para resposta',
    );

    public static $opcoesAtividade = array(
        'alimentacao'   => 'Alimentação',
        'higiene'       => 'Higiene',
        'equipamentos'  => 'Equipamentos',
        'vestuario'     => 'Vestuário',
        'comunicacao'   => 'Comunicação',
        'manipulacao'   => 'Manipular Objetos',
        'tarefas'       => 'Tarefas',
        'outros'        => 'Outros',
    );

    public function anamnesetratamento()
    {
        return $this->hasMany('Anamnesetratamento');
    }

    public static function bloco($bloco, $trashed = false)
    {
        return self::where('bloco', '=', $bloco)->orderBy('ordem')->get();
    }
}
