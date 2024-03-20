<?php

class Anamnesetratamento extends \Eloquent
{
    protected $table = 'anamnesetratamentos';

    // Add your validation rules here
    public static $rules = array(
        'tratamento_id' => 'required|integer',
        'anamnese_id' => 'required|integer',
        'checkbox' => 'required|in:on,off',
    );

    // Don't forget to fill this array
    protected $fillable = array(
        'tratamento_id', 'anamnese_id',
        'checkbox', 'opcao', 'resposta',
    );

    public function anamnese()
    {
        return $this->belongsTo('Anamnese');
    }
    public function tratamento()
    {
        return $this->belongsTo('Tratamento');
    }

    public static $opcoes = array(
        0  => '',
        10 => 'Realiza',
        20 => 'Realiza com dificuldade ou ajuda',
        30 => 'Não realiza',
    );

    // public static $dificuldade = array(
    //     '' => '',
    //     'Realiza' => 'Realiza',
    //     'Realiza com dificuldade ou ajuda' => 'Realiza com dificuldade ou ajuda',
    //     'Não realiza' => 'Não realiza',
    // );

    public function setTratamentoIdAttribute($value)
    {
        $this->attributes['tratamento_id'] = empty(trim($value)) ? null : $value;
    }

    public function setAnamneseIdAttribute($value)
    {
        $this->attributes['anamnese_id'] = empty(trim($value)) ? null : $value;
    }

    public static function dados($tratamento)
    {
        $anamnese = Anamnese::get();
        $dados    = $dadosAT    = array();
        $at       = $tratamento->anamnesetratamento()->get();
        foreach ($at as $item) {
            $dadosAT[$item->anamnese_id] = $item;
        }
        foreach ($anamnese as $item) {
            if (isset($dadosAT[$item->id])) {
                $dados[$item->id] = $dadosAT[$item->id];
            } else {
                $data = array(
                    'tratamento_id' => $tratamento->id,
                    'anamnese_id' => $item->id,
                    'checkbox' => 'off',
                );
                $dados[$item->id] = self::create($data);
            }
        }

        return $dados;
    }

    public static function posicionalOpcoes(Tratamento $t)
    {
        $result = $tIds = array();

        $flagAnteriores = in_array('C', explode(',', $t->anexar_anteriores));
        if ($flagAnteriores) {
            $tratamentos = Tratamento::select('id', 'created_at')
                ->where('id', '<=', $t->id)
                ->where('paciente_id', '=', $t->paciente_id)
                ->where('lesao_id', '=', $t->lesao_id)
                ->orderBy('id', 'desc')
                ->get();
            foreach ($tratamentos as $row) {
                $tIds[$row->id] = $row->created_at;
            }
        } else {
            $tIds[$t->id] = $t->created_at;
        }

        foreach ($tIds as $id => $data) {

            if (! isset($result[$id]['data'])) {
                $result[$id]['data'] = $data;
            }

            foreach (self::$opcoes as $item => $label) {
                $c = self::where('opcao', '=', $item)
                    ->where('avaliado', '=', 'on')
                    ->where('tratamento_id', '=', $id)
                    ->count();
                $result[$id]['itens'][$item]       = $c;
                $result[$id]['posicional'][$item]  = 0;
            }

            $result[$id]['total'] = self::where('avaliado', '=', 'on')
                ->where('tratamento_id', '=', $id)
                ->count();

            foreach ($result as $tId => $dados) {
                foreach ($dados['itens'] as $item => $value) {
                    if ($dados['total'] > 0) {
                        $posicao = ($value / $dados['total']) * 100;
                        $result[$id]['posicional'][$item] = number_format($posicao, 0, ',', '.');
                    }
                }
            }

        }
        return $result;
    }
}
