<?php

namespace app\controllers\Protocols\Tests\Goniometro;

use app\models\Protocols\Test;
use app\models\Protocols\Tests\Goniometro\Param;
use app\models\Protocols\Tests\Goniometro\Paramgroup;

class ParamController extends \BaseController
{
	private $test = null;
	private $routePath = null;
	private $viewPath = null;

	public function __construct()
	{
		\User::allowedCredentials(array(10));
		$this->test = Test::findByNamespace(__NAMESPACE__);
		$this->routePath = $this->test->getRoutePrefix().'.param';
		$this->viewPath = 'protocols.tests.'.$this->routePath;
	}

	public function index()
	{
		$test = $this->test;
		$data = Param::all();
		$routePath = $this->routePath;

		return \View::make(
			$this->viewPath.'.index', compact('data', 'test', 'routePath')
		);
	}

	public function create()
	{
		$test = $this->test;
		$data = new Param;
		$paramgroups = Paramgroup::lists('name', 'id');
		$action = route($this->routePath.'.store');
		$routePath = $this->routePath;

    return \View::make(
			$this->viewPath.'.form',
			compact('data', 'paramgroups', 'action', 'test', 'routePath')
		);
	}

	public function store()
	{
		$validator = \Validator::make($post = \Input::all(), Param::$rules);
		if ($validator->fails()){
		return \Redirect::back()->withErrors($validator)->withInput();
		}
		Param::create($post);

		return \Redirect::route($this->routePath.'.index');
	}

	public function edit($id)
	{
		$test = $this->test;
		$data = Param::findOrFail($id);
		$paramgroups = Paramgroup::lists('name', 'id');
		$action = route($this->routePath.'.update', ['id' => $data->id]);
		$routePath = $this->routePath;

    	return \View::make(
			$this->viewPath.'.form',
			compact('test', 'data', 'paramgroups', 'action', 'routePath')
		);
	}

	public function update($id)
	{
		$data = Param::findOrFail($id);
		$validator = \Validator::make($post = \Input::all(), Param::$rules);
    if ($validator->fails()){
        return \Redirect::back()->withErrors($validator)->withInput();
    }
    $data->update($post);

    return \Redirect::route($this->routePath.'.index');
	}

	public function destroy($id)
	{
		Param::destroy($id);

		return \Redirect::back();
	}
}
