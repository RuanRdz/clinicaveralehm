<?php

namespace app\controllers\Protocols\Tests\Avds;

use app\models\Protocols\Test;
use app\models\Protocols\Tests\Avds\Scale;

class ScaleController extends \BaseController
{
	private $test = null;
	private $routePath = null;
	private $viewPath = null;

	public function __construct()
	{
		\User::allowedCredentials(array(10));
		$this->test = Test::findByNamespace(__NAMESPACE__);
		$this->routePath = $this->test->getRoutePrefix().'.scale';
		$this->viewPath = 'protocols.tests.'.$this->routePath;
	}

	public function index()
	{
		$test = $this->test;
		$data = Scale::orderBy('sort')->get();
		$routePath = $this->routePath;

		return \View::make(
			$this->viewPath.'.index', compact('data', 'test', 'routePath')
		);
	}

	public function create()
	{
		$test = $this->test;
		$data = new Scale;
		$action = route($this->routePath.'.store');
		$routePath = $this->routePath;

    return \View::make(
			$this->viewPath.'.form',
			compact('data', 'action', 'test', 'routePath')
		);
	}

	public function store()
	{
		$validator = \Validator::make($post = \Input::all(), Scale::$rules);
    if ($validator->fails()){
      return \Redirect::back()->withErrors($validator)->withInput();
    }
    Scale::create($post);

    return \Redirect::route($this->routePath.'.index');
	}

	public function edit($id)
	{
		$test = $this->test;
		$data = Scale::findOrFail($id);
		$action = route($this->routePath.'.update', ['id' => $data->id]);
		$routePath = $this->routePath;

    return \View::make(
			$this->viewPath.'.form',
			compact('test', 'data', 'action', 'routePath')
		);
	}

	public function update($id)
	{
		$data = Scale::findOrFail($id);
		$validator = \Validator::make($post = \Input::all(), Scale::$rules);
    if ($validator->fails()){
        return \Redirect::back()->withErrors($validator)->withInput();
    }
    $data->update($post);

    return \Redirect::route($this->routePath.'.index');
	}

	public function destroy($id)
	{
		Scale::destroy($id);

		return \Redirect::back();
	}
}
