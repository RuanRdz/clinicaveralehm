<?php

namespace app\controllers\Protocols\Tests\Avds;

use app\models\Protocols\Test;
use app\models\Protocols\Tests\Avds\Paramgroup;
use app\models\Protocols\Tests\Avds\Param;
use app\models\Protocols\Tests\Avds\Scale;
use app\models\Protocols\Tests\Avds\Data;
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
		$scale = Scale::orderBy('sort')->get();
		$routePath = $this->routePath;

		return \View::make(
			$this->viewPath.'.index',
			compact('treatment', 'test', 'testData', 'scale', 'routePath')
		);
	}

	public function create($treatment_id)
	{
		$test = $this->test;
		$treatment = Treatment::findOrFail($treatment_id);
		$data = new Data;
		$paramgroups = Paramgroup::with('params')->orderBy('sort')->get();
        $scale = Scale::orderBy('sort')->get();
		$action = route($this->routePath.'.store');
		$routePath = $this->routePath;

		return \View::make($this->viewPath.'.form-create', compact(
            'test', 'treatment', 'data',
            'paramgroups', 'scale', 'action', 'routePath'
        ));
	}

    public function edit($id)
    {
        $test = $this->test;
        $data = Data::findOrFail($id);
        $treatment = Treatment::findOrFail($data->treatment_id);
        $paramgroups = Paramgroup::with('params')->orderBy('sort')->get();
		$scale = Scale::orderBy('sort')->get();
		$routePath = $this->routePath;
        $action = route($this->routePath.'.update');

		return \View::make($this->viewPath.'.form-edit', compact(
            'test', 'treatment', 'data',
            'paramgroups', 'scale', 'action', 'routePath'
		));
    }

	public function store()
	{
        \Input::flashOnly('testdate');

		$validator = \Validator::make($post = \Input::all(), Data::$rules);
		if ($validator->fails()){
		   return \Redirect::back()
		 		->withErrors($validator)->withInput();
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
