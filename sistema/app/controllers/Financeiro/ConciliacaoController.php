<?php

class ConciliacaoController extends BasefinanceiroController {

    public function __construct() {
        User::allowedCredentials(array(10));
    }

    public function index() {

        $dados = [];
        return View::make('financeiro.conciliacao', compact('dados'));
    }

    public function upload() 
    {
        $arquivo = Input::file('arquivo');
        $extensao = $arquivo->getClientOriginalExtension();

        $extensoes = array('xls', 'xlsx');
        if (!in_array(strtolower($extensao), $extensoes)) {
            return Redirect::back()
                ->with('fail', 'Envio de arquivos ".'.$extensao.'" não são permitidos.');
        }
        
        $dados = $this->processar(Input::file('arquivo'));

        return View::make('financeiro.conciliacao', compact('dados'));
    }

    private function processar($file)
    {
        $sheet = $this->readPlanilha($file);
        $dados = $sheet['dados'];
        $codigos = $sheet['codigos'];
        $lancamentos = $this->queryLancamentos($codigos);

        $resultado = [];
        foreach ($dados as $key => $item) {
            $resultado[$key] = $item;
            $resultado[$key]['lancamentos'] = [];
            foreach ($lancamentos as $lancamento) {
                if ($item['sheet_codigo'] != $lancamento->db_codigo) {
                    continue;
                }
                $lancamento->db_valor = valorBr($lancamento->db_valor);
                $lancamento->db_valor_pago = valorBr($lancamento->db_valor_pago);
                if (
                    $item['sheet_valor'] != $lancamento->db_valor
                    && $item['sheet_valor'] != $lancamento->db_valor_pago
                    && $item['sheet_favorecido'] != $lancamento->db_favorecido
                ) {
                    $color = 'text-red-600';
                } else if (
                    $item['sheet_valor'] != $lancamento->db_valor
                    && $item['sheet_valor'] != $lancamento->db_valor_pago
                ) {
                    $color = 'text-purple-600';
                } else {
                    $color = 'text-gray-600';
                }
                
                $resultado[$key]['lancamentos'][] = [
                    'id' => $lancamento->id,
                    'db_codigo' => $lancamento->db_codigo,
                    'db_valor' => $lancamento->db_valor,
                    'db_valor_pago' => $lancamento->db_valor_pago,
                    'db_favorecido' => $lancamento->db_favorecido,
                    'color' => $color
                ];
            }
        }

        return $resultado;
    }

    private function readPlanilha($file)
    {
        $objPHPExcel = PHPExcel_IOFactory::load($file->getPathName());
        $sheet = $objPHPExcel->getSheet(0);

        $dados = [];
        $codigos = [];
        $linha = 2;
        foreach ($sheet->getRowIterator() as $row) {
            $col_A = (string) $objPHPExcel->getActiveSheet()->getCell("A$linha")->getValue();
            $col_B = (string) $objPHPExcel->getActiveSheet()->getCell("B$linha")->getValue();
            $col_C = (string) $objPHPExcel->getActiveSheet()->getCell("C$linha")->getValue();
            if (empty($col_A) && empty($col_B) && empty($col_C)) {
                continue;
            }
            $dados[] = [
                'sheet_codigo' => $col_A,
                'sheet_valor' => $col_B,
                'sheet_favorecido' => mb_strtoupper(trim($col_C), 'UTF-8'),
            ];
            if (!empty($col_A)) {
                $codigos[$col_A] = $col_A;
            }
            $linha++;
        }
        $codigos = array_values($codigos);

        return [
            'dados' => $dados,
            'codigos' => $codigos,
        ];
    }

    private function queryLancamentos($codigos)
    {
        return DB::table('financeiro')
            ->select(
                'financeiro.id', 
                'financeiro.codigo AS db_codigo', 
                'financeiro.valor AS db_valor', 
                'financeiro.valor_pago AS db_valor_pago',
                DB::raw(
                    "(
                        CASE 
                            WHEN fornecedor_id != '' THEN (SELECT UPPER(TRIM(nome)) FROM fornecedores WHERE id = financeiro.fornecedor_id)
                            WHEN tratamento_id != '' THEN (SELECT UPPER(TRIM(nome)) FROM pacientes INNER JOIN tratamentos ON pacientes.id = tratamentos.paciente_id WHERE tratamentos.id = financeiro.tratamento_id)
                            END
                    ) AS db_favorecido"
                )
            )
            ->whereIn('financeiro.codigo', $codigos)
            ->get();
    }
}
