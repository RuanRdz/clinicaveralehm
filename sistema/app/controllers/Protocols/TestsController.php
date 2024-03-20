<?php

namespace app\controllers\Protocols;

use app\models\Protocols\Protocol;
use app\models\Protocols\Test;

class TestsController extends \BaseController {

	public function __construct()
	{
    \User::allowedCredentials(array(10));
  }

	public function create()
	{
		$test = new Test;
		$protocols = array('' => '') + Protocol::lists('name', 'id');
		$action = route('tests.store');
    return \View::make(
			'protocols.manage.form-test',
			compact('test', 'protocols', 'action')
		);
	}

	public function store()
	{
		$rules = Test::$rules + ['namespace' => 'unique:tests,namespace'];
    $validator = \Validator::make($post = \Input::all(), $rules);
    if ($validator->fails()){
      return \Redirect::back()->withErrors($validator)->withInput();
    }
    Test::create($post);
    return \Redirect::route('protocols.index');
	}

	public function edit($id)
	{
		$test = Test::findOrFail($id);
		$protocols = array('' => '') + Protocol::lists('name', 'id');
		$action = route('tests.update', ['id' => $test->id]);
    return \View::make(
			'protocols.manage.form-test',
			compact('test', 'protocols', 'action')
		);
	}

	public function update($id)
	{
		$test = Test::findOrFail($id);
		$rules = Test::$rules + ['namespace' => 'unique:tests,namespace,'.$test->id];
		$validator = \Validator::make($post = \Input::all(), $rules);
    if ($validator->fails()){
      return \Redirect::back()->withErrors($validator)->withInput();
    }
    $test->update($post);
    return \Redirect::route('protocols.index');
	}
}
