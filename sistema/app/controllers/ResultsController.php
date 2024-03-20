<?php

class ResultsController extends BaseController
{
    protected $service;

    public function index($chart = null)
    {
        switch ($chart) {
            case 'createdPatientsAnnually': $data = $this->createdPatientsAnnually(); break;
            case 'treatmentsFinishedAnnually': $data = $this->treatmentsFinishedAnnually(); break;
            case 'treatmentsCanceledAnnually': $data = $this->treatmentsCanceledAnnually(); break;
            case 'appointmentsFinishedAnnually': $data = $this->appointmentsFinishedAnnually(); break;
            case 'appointmentsCanceledAnnually': $data = $this->appointmentsCanceledAnnually(); break;
            default: $data = $this->createdPatientsAnnually(); break;
        }

        return View::make('results.index', compact('data'));
    }

    //

    private function parseChartData($data)
    {
        $labels = [];
        $series = [];

        foreach ($data as $row) {
            $labels[] = $row->label;
            $series[] = $row->value;
        }

        return [
            'labels' => $labels,
            'series' => $series,
        ];
    }

    private function createdPatientsAnnually()
    {
        $data = DB::table('pacientes')
            ->select(DB::raw("DATE_FORMAT(created_at, '%Y') as label, count('id') as value"))
            ->where(DB::raw("DATE_FORMAT(created_at, '%Y')"), '>=', 2014)
            ->groupBy(DB::raw("DATE_FORMAT(created_at, '%Y')"))
//            ->remember(10)
            ->get();

        $title = 'Novos Pacientes - Anual';

        return array_merge(['title' => $title], $this->parseChartData($data));
    }

    private function treatmentsFinishedAnnually()
    {
        $data = DB::table('tratamentos')
            ->select(DB::raw("DATE_FORMAT(created_at, '%Y') as label, count('id') as value"))
            ->where('tratamentosituacao_id', '=', 2)
            ->whereNotNull('created_at')
            ->where(DB::raw("DATE_FORMAT(created_at, '%Y')"), '>=', 2014)
            ->groupBy(DB::raw("DATE_FORMAT(created_at, '%Y')"))
            ->get();

        $title = 'Tratamentos Finalizados - Anual';

        return array_merge(['title' => $title], $this->parseChartData($data));
    }

    private function treatmentsCanceledAnnually()
    {
        $data = DB::table('tratamentos')
            ->select(DB::raw("DATE_FORMAT(created_at, '%Y') as label, count('id') as value"))
            ->where('tratamentosituacao_id', '=', 3)
            ->whereNotNull('created_at')
            ->where(DB::raw("DATE_FORMAT(created_at, '%Y')"), '>=', 2014)
            ->groupBy(DB::raw("DATE_FORMAT(created_at, '%Y')"))
            ->get();

        $title = 'Tratamentos Cancelados - Anual';

        return array_merge(['title' => $title], $this->parseChartData($data));
    }

    private function appointmentsFinishedAnnually()
    {
        $data = DB::table('agendas')
            ->select(DB::raw("DATE_FORMAT(data_sessao, '%Y') as label, count('id') as value"))
            ->where('genero', '=', 'atendimento')
            ->where('agendasituacao_id', '=', 2)
            ->whereNotNull('data_sessao')
            ->where(DB::raw("DATE_FORMAT(data_sessao, '%Y')"), '>=', 2014)
            ->groupBy(DB::raw("DATE_FORMAT(data_sessao, '%Y')"))
            ->get();

        $title = 'Sessões Finalizadas - Anual';

        return array_merge(['title' => $title], $this->parseChartData($data));
    }

    private function appointmentsCanceledAnnually()
    {
        $data = DB::table('agendas')
            ->select(DB::raw("DATE_FORMAT(data_sessao, '%Y') as label, count('id') as value"))
            ->where('genero', '=', 'atendimento')
            ->where('agendasituacao_id', '=', 6)
            ->whereNotNull('data_sessao')
            ->where(DB::raw("DATE_FORMAT(data_sessao, '%Y')"), '>=', 2014)
            ->groupBy(DB::raw("DATE_FORMAT(data_sessao, '%Y')"))
            ->get();

        $title = 'Sessões Canceladas - Anual';

        return array_merge(['title' => $title], $this->parseChartData($data));
    }
}
