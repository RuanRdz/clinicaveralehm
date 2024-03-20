<?php

namespace app\controllers\Protocols\Tests\Goniometro;

use app\models\Protocols\Test;
use app\models\Protocols\Tests\Goniometro\Param;
use app\models\Protocols\Tests\Goniometro\Paramgroup;
use app\models\Protocols\Tests\Goniometro\Data;
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
		$params = Param::selectBox();
		$sides = Data::$sides;
		$action = route($this->routePath.'.store');

		return \View::make($this->viewPath.'.index', compact(
			'treatment', 'test', 'testData', 'routePath',
			'data', 'params', 'sides', 'action'
		));
	}

    public function edit($id)
    {
        $test = $this->test;
        $data = Data::findOrFail($id);
        $treatment = Treatment::findOrFail($data->treatment_id);

		$params = Param::selectBox();
		$sides = Data::$sides;
		$routePath = $this->routePath;
        $action = route($this->routePath.'.update');

		return \View::make($this->viewPath.'.form-edit', compact(
			'treatment', 'test', 'routePath',
			'data', 'params', 'sides', 'action'
		));
    }

	public function store()
	{
        \Input::flashOnly('testdate', 'side_id');
        
		$validator = \Validator::make($post = \Input::all(), Data::$rules);
		if ($validator->fails()){
			return \Redirect::back()
				->withErrors($validator)
				->withInput();
		}

		Data::storeTest($post);

		return \Redirect::route(
			$this->routePath.'.index',
			['treatment_id' => $post['treatment_id']]
		);
	}

    public function update()
    {
		$validator = \Validator::make($post = \Input::all(), Data::$rules);
		if ($validator->fails()){
		   return \Redirect::back()
		 		->withErrors($validator)->withInput();
		}

        $data = Data::findOrFail($post['id']);
        $data->update($post);

		return \Redirect::route(
			$this->routePath.'.index',
			['treatment_id' => $post['treatment_id']]
		);
    }

	public function destroy($id)
	{
		Data::destroy($id);

		return \Redirect::back();
	}

}
