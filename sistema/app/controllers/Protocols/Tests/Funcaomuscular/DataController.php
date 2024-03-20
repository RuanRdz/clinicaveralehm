<?php

namespace app\controllers\Protocols\Tests\Funcaomuscular;

use app\models\Protocols\Test;
use app\models\Protocols\Tests\Funcaomuscular\Paramgroup;
use app\models\Protocols\Tests\Funcaomuscular\Param;
use app\models\Protocols\Tests\Funcaomuscular\Scale;
use app\models\Protocols\Tests\Funcaomuscular\Data;
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
		$scale = Scale::all();
		$routePath = $this->routePath;

		// Form
		$data = new Data;
        $paramgroups = Paramgroup::get();
        $sides = Data::$sides;
		$action = route($this->routePath.'.store');

		return \View::make($this->viewPath.'.index', compact(
			'treatment', 'test', 'testData', 'scale', 'routePath',
			'data', 'paramgroups', 'sides', 'action'
		));
	}
    
    public function edit($id)
    {
        $test = $this->test;
        $data = Data::findOrFail($id);
        $treatment = Treatment::findOrFail($data->treatment_id);

        $scale = Scale::all();
        $paramgroups = Paramgroup::get();
        $sides = Data::$sides;
		$routePath = $this->routePath;
        $action = route($this->routePath.'.update');

		return \View::make($this->viewPath.'.form-edit', compact(
			'treatment', 'test', 'scale', 'routePath',
			'data', 'paramgroups', 'sides', 'action'
		));
    }

	public function store()
	{
        \Input::flashOnly('testdate', 'side_id');

		$validator = \Validator::make($post = \Input::all(), Data::$rules);

		if ($validator->fails()){
		   return \Redirect::back()
		 		->withErrors($validator)->withInput();
		}

		Data::storeTest($post);

		\Session::flash('filter_param', $post['filter_param']);

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
