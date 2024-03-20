<?php

namespace app\controllers\Protocols\Tests\Forca;

use app\models\Protocols\Test;
use app\models\Protocols\Tests\Forca\Param;
use app\models\Protocols\Tests\Forca\Scale;
use app\models\Protocols\Tests\Forca\Data;
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
		$scale = Scale::selectBox();
		$params = Param::orderBy('sort')->get();
		$hands = Param::$hands;
		$action = route($this->routePath.'.store');

		return \View::make($this->viewPath.'.index', compact(
			'treatment', 'test', 'testData', 'routePath',
			'data', 'scale', 'params', 'hands', 'action'
		));
	}

	/**
	 * Edit a bundle of tests
	 * @param $id [testbundle attr]
	 */
	public function edit($id)
	{
		$data = Data::where('testbundle', '=', $id)->get()->toArray();	
		if (count($data) == 0) {
			die('Não há dados para edição');
		}

		$first = $data[0];
		$treatment_id = $first['treatment_id'];
		$treatment = Treatment::findOrFail($treatment_id);

		$testdate = $first['testdate'];

		$test = $this->test;
		$scale = Scale::selectBox();
		$params = Param::orderBy('sort')->get();
		$hands = Param::$hands;
		$action = route($this->routePath.'.update', ['id' => $id]);
		$routePath = $this->routePath;

		$scoreData = array();
		foreach($data as $item)
		{
			$scoreData[$item['param_id']] = array(
				'id' => $item['id'],
				'scale_id_right' => $item['scale_id_right'],
				'scale_id_left' => $item['scale_id_left'],
			);
		}
		// var_dump($scoreData);

		return \View::make(
			$this->viewPath.'.form-edit', compact(
				'id',
				'test', 'scoreData', 'treatment', 'testdate',
				'scale', 'params', 'hands', 'action', 'routePath'
			)
		);
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
        
		foreach ($post['values'] as $id => $values) {
            $data = Data::find($id);
            if ($data) {
                $values['testdate'] = $post['testdate'];
                $data->update($values);
            }
		}

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
		$data = Data::where('testbundle', '=', $id)->get();
		foreach ($data as $row) {
			$row->delete();
		}

		return \Redirect::back();
	}

}
