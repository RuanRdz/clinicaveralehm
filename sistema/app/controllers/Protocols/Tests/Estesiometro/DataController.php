<?php

namespace app\controllers\Protocols\Tests\Estesiometro;

use app\models\Protocols\Test;
use app\models\Protocols\Tests\Estesiometro\Param;
use app\models\Protocols\Tests\Estesiometro\Scale;
use app\models\Protocols\Tests\Estesiometro\Data;
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
		$scale = Scale::presentLegend();
		$routePath = $this->routePath;

		// Form 
		$data = new Data;
		$params = Param::all();
		$action = route($this->routePath.'.store');

		return \View::make(
			$this->viewPath.'.index',
			compact(
				'treatment', 'test', 'testData', 'scale', 'routePath',
				'data', 'params', 'action'
			)
		);
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

	/**
	 * Delete a bundle of tests
	 * @param $id [testbundle attr]
	 */
	public function destroy($id)
	{
		Data::destroy($id);

		return \Redirect::back();
	}

}
