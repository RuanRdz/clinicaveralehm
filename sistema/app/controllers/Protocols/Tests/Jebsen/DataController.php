<?php

namespace app\controllers\Protocols\Tests\Jebsen;

use app\models\Protocols\Test;
use app\models\Protocols\Tests\Jebsen\Param;
use app\models\Protocols\Tests\Jebsen\Data;
use \Tratamento as Treatment;

class DataController extends \BaseController
{
	private $test = null;
	private $routePath = null;
	private $viewPath = null;

	public function __construct()
	{
		\User::allowedCredentials(array(10, 20));
		$this->test = Test::findByNamespace(__NAMESPACE__);
		$this->routePath = $this->test->getRoutePrefix().'.data';
		$this->viewPath = 'protocols.tests.'.$this->routePath;
	}

	public function index($treatment_id)
	{
		$treatment = Treatment::findOrFail($treatment_id);
		$test = $this->test;
        $testData = Data::presentData(Data::getData($treatment));
        $routePath = $this->routePath;
        
		// Form 
		$data = new Data;
		$params = Param::orderBy('sort')->get();
		$action = route($this->routePath.'.store');

		return \View::make(
			$this->viewPath.'.index',
			compact(
				'treatment', 'test', 'testData', 'routePath',
				'data', 'params', 'action'
			)
		);
	}

	public function store()
	{
        // \Input::flashOnly('testdate');
        \Input::flash();

		$validator = \Validator::make($post = \Input::all(), Data::$rules);
		if ($validator->fails()){
            return \Redirect::back()->withErrors($validator)->withInput();
		}
        if (!isset($post['time'])) {
            \App::abort(422, 'Todos os itens do teste devem ser preenchidos');
        }
        foreach ($post['time'] as $param_id => $time) {
            $data = [
                'param_id' => $param_id,
                'treatment_id' => $post['treatment_id'],
                'testdate' => $post['testdate'],
                'time_left_hand' => $time['left_hand'],
                'time_right_hand' => $time['right_hand'],
            ];
            Data::storeTest($data);
        }

		return \Redirect::route(
			$this->routePath.'.index',
			['treatment_id' => $post['treatment_id']]
		);
	}

	/**
	 * Delete a bundle of tests by date
	 * @param $date [testdate attr]
	 * @param $date [testdate attr]
	 */
	public function destroyByDate($treatment_id, $date)
	{
        if (empty($treatment_id) || empty($date)) {
            return \Redirect::back();
        }
        $treatment = Treatment::findOrFail($treatment_id);
        $date = brDateToDatabase($date);

        $data = Data::where('testdate', '=', $date)
            ->where('treatment_id', '=', $treatment->id)
            ->get();

        foreach ($data as $item) {
            $item->delete();
        }

		return \Redirect::back();
	}
}
