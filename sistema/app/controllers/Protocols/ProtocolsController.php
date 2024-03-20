<?php

namespace app\controllers\Protocols;

use app\models\Protocols\Protocol;

class ProtocolsController extends \BaseController {

	public function __construct()
	{
    \User::allowedCredentials(array(10));
  }

	public function index()
	{
		$protocols = Protocol::with('tests')->orderBy('protocols.sort')->get();
		return \View::make('protocols.manage.index', compact('protocols'));
	}

	public function create()
	{
		$protocol = new Protocol;
		$action = route('protocols.store');
    return \View::make('protocols.manage.form', compact('protocol', 'action'));
	}

	public function store()
	{
    $validator = \Validator::make($post = \Input::all(), Protocol::$rules);
    if ($validator->fails()){
        return \Redirect::back()->withErrors($validator)->withInput();
    }
    Protocol::create($post);
    return \Redirect::route('protocols.index');
	}

	public function edit($id)
	{
		$protocol = Protocol::findOrFail($id);
		$action = route('protocols.update', ['id' => $protocol->id]);
    return \View::make('protocols.manage.form', compact('protocol', 'action'));
	}

	public function update($id)
	{
		$protocol = Protocol::findOrFail($id);
		$validator = \Validator::make($post = \Input::all(), Protocol::$rules);
    if ($validator->fails()){
        return \Redirect::back()->withErrors($validator)->withInput();
    }
    $protocol->update($post);
    return \Redirect::route('protocols.index');
	}
}
