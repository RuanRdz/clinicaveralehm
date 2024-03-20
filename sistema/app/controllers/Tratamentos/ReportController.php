<?php

use Tratamento as Treatment;
use \Mpdf\Mpdf;

class ReportController extends \BaseController {

    public function __construct() 
    {
        // User::allowedCredentials(array(10, 20));
    }

    public function index($treatment_id)
    {
        $treatment = Treatment::findOrFail($treatment_id);

        $opcoes = array(
            'B' => Anamnese::bloco('B'),
            'E' => Anamnese::bloco('E'),
            'F' => Anamnese::bloco('F'),
        );
        $blocos = Anamnese::$blocos;
        $dados = Anamnesetratamento::dados($treatment);

        // Header
        $patient_name = $treatment->paciente->nome;
        $agenda = $treatment
            ->agendas()
            ->where('agendasituacao_id', '=', 2)
            ->orderBy('data_sessao')
            ->get()
            ->toArray();
        $num_sessoes = count($agenda);
        if ($num_sessoes > 0) {
            $sessao_inicial = $agenda[0]['data_sessao'];
            $sessao_final   = end($agenda);
            $sessao_final   = $sessao_final['data_sessao'];
        } else {
            $sessao_inicial = '-';
            $sessao_final   = '-';
        }

        // Filtro [não está sendo usado..]
        // $query = \Request::query();
        // dd($query);
        // $with_previous = Request::input('with_previous');

		$estesiometro['test'] = app\models\Protocols\Test::findByNamespace('app\controllers\Protocols\Tests\Estesiometro');
        $estesiometroData = app\models\Protocols\Tests\Estesiometro\Data::getData($treatment);
		$estesiometro['data'] = app\models\Protocols\Tests\Estesiometro\Data::presentData($estesiometroData);
        $estesiometro['scale'] = app\models\Protocols\Tests\Estesiometro\Scale::presentLegend();
        $estesiometro['has-data'] = count($estesiometroData);

		$dor['test'] = app\models\Protocols\Test::findByNamespace('app\controllers\Protocols\Tests\Dor');
        $dorData = app\models\Protocols\Tests\Dor\Data::getData($treatment);
        $dor['data'] = app\models\Protocols\Tests\Dor\Data::presentData($dorData);
        $dor['types'] = app\models\Protocols\Tests\Dor\Data::$types;
        $dor['scale'] = app\models\Protocols\Tests\Dor\Scale::all();
        $dor['has-data'] = count($dorData);

		$kapandji['test'] = app\models\Protocols\Test::findByNamespace('app\controllers\Protocols\Tests\Kapandji');
        $kapandjiData = app\models\Protocols\Tests\Kapandji\Data::getData($treatment);
		$kapandji['data'] = app\models\Protocols\Tests\Kapandji\Data::presentData($kapandjiData);
        $kapandji['sides'] = app\models\Protocols\Tests\Kapandji\Data::$sides;
        $kapandji['scale'] = app\models\Protocols\Tests\Kapandji\Scale::all();
        $kapandji['has-data'] = count($kapandjiData);

		$forca['test'] = app\models\Protocols\Test::findByNamespace('app\controllers\Protocols\Tests\Forca');
        $forcaData = app\models\Protocols\Tests\Forca\Data::getData($treatment);
        $forca['data'] = app\models\Protocols\Tests\Forca\Data::presentData($forcaData);
        $forca['has-data'] = count($forcaData);

		$funcaomuscular['test'] = app\models\Protocols\Test::findByNamespace('app\controllers\Protocols\Tests\Funcaomuscular');
        $funcaomuscularData = app\models\Protocols\Tests\Funcaomuscular\Data::getData($treatment);
        $funcaomuscular['data'] = app\models\Protocols\Tests\Funcaomuscular\Data::presentData($funcaomuscularData);
        $funcaomuscular['scale'] = app\models\Protocols\Tests\Funcaomuscular\Scale::all();
        $funcaomuscular['has-data'] = count($funcaomuscularData);

		$goniometro['test'] = app\models\Protocols\Test::findByNamespace('app\controllers\Protocols\Tests\Goniometro');
        $goniometroData = app\models\Protocols\Tests\Goniometro\Data::getData($treatment);
        $goniometro['data'] = app\models\Protocols\Tests\Goniometro\Data::presentData($goniometroData);
        $goniometro['has-data'] = count($goniometroData);

        $avds['test'] = app\models\Protocols\Test::findByNamespace('app\controllers\Protocols\Tests\Avds');
        $avdsData = app\models\Protocols\Tests\Avds\Data::getData($treatment);
		$avds['data'] = app\models\Protocols\Tests\Avds\Data::presentData($avdsData);
        $avds['scale'] = app\models\Protocols\Tests\Avds\Scale::orderBy('sort')->get();
        $avds['has-data'] = count($avdsData);

        $tu = app\models\Protocols\Tests\Terminologiauniforme\Terminologia::bundleTreeHtml($treatment);
        $tu['test'] = app\models\Protocols\Test::findByNamespace('app\controllers\Protocols\Tests\Terminologiauniforme');

        $jebsen['test'] = app\models\Protocols\Test::findByNamespace('app\controllers\Protocols\Tests\Jebsen');
        $jebsenData = app\models\Protocols\Tests\Jebsen\Data::getData($treatment);
        $jebsen['data'] = app\models\Protocols\Tests\Jebsen\Data::presentData($jebsenData);
        $jebsen['params'] = app\models\Protocols\Tests\Jebsen\Param::orderBy('sort')->get();
        $jebsen['has-data'] = count($jebsenData);

        $compact = compact(
            'treatment', 'patient_name',

            'blocos', 'opcoes', 'dados',
            'num_sessoes', 'sessao_inicial', 'sessao_final',
            'opcoesDificuldade', 'posicionalOpcoes',

            'tu', 'avds', 'estesiometro', 'dor', 'kapandji', 
            'forca', 'funcaomuscular', 'goniometro',
            'jebsen'
        );

        return View::make('tratamentos.report.index', $compact);
        
        $view = View::make('tratamentos.report.index', $compact);
        $mpdf = new Mpdf(['tempDir' => storage_path().'/temp/mpdf']);
        $mpdf->WriteHTML($view->render(), 0);
        $mpdf->Output();
    }

    public function update()
    {

        $post = Input::all();

        $t = Tratamento::findOrFail($post['tratamento_id']);
        $t->info_sessoes = $post['info_sessoes'];
        $t->save();

        // $validator = Validator::make($data = Input::all(), Report::$rules);
        // if ($validator->fails()){
        //     return Redirect::back()->withErrors($validator)->withInput();
        // }
        // dd($data);

        return Redirect::back();
    }
}
