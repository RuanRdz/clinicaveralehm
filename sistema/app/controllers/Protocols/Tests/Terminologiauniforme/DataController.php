<?php

namespace app\controllers\Protocols\Tests\Terminologiauniforme;

use app\models\Protocols\Test;
use app\models\Protocols\Tests\Terminologiauniforme\Terminologia;
use \Tratamento as Treatment;

class DataController extends \BaseController {

	public function __construct()
	{
		\User::allowedCredentials(array(10, 20));
		$this->test = Test::findByNamespace(__NAMESPACE__);
		$this->routePath = $this->test->getRoutePrefix().'.data';
		$this->viewPath = 'protocols.tests.'.$this->routePath;
	}

	public function index($id)
	{
		\User::allowedCredentials(array(10, 20));
		$treatment = Treatment::findOrFail($id);

		$terminologias = Terminologia::all()->toArray();
		$dados = $treatment->terminologias->lists('id');
		if ($dados) {
			$array = array();
			foreach ($terminologias as $values) {
				$array[] = array(
			      'id' 		    => $values['id'],
			      'parent_id'   => $values['parent_id'],
			      'level'       => $values['level'],
			      'code'        => $values['code'],
			      'label' 	    => $values['label'],
			      'is_question' => $values['is_question'],
			      'checked' 	=> in_array($values['id'], $dados) ? 1 : 0,
				);
			}
			$dados = $array;
		} else {
			$dados = $terminologias;
		}
        $tree = Terminologia::buildEditableTreeHTML($dados);
		$test = $this->test;
		$action = route($this->routePath.'.update', array('id' => $treatment->id));
		$routePath = $this->routePath;

        return \View::make(
			$this->viewPath.'.form', compact(
				'treatment', 'tree', 'action', 'test', 'routePath'
			)
		);
	}

	public function update()
	{
		\User::allowedCredentials(array(10, 20));
		$post = \Input::all();
		$treatment = Treatment::findOrFail($post['tratamento_id']);
		$treatment->terminologias()->sync($post['terminologia_tratamento']);
		$treatment->setFezAvaliacao();
		return \Redirect::back()->with('success', 'Cadastro atualizado.');
		// return \Redirect::route(
		// 	$this->routePath.'.index',
		// 	['id' => $treatment->id]
		// )->with('success', 'Cadastro atualizado.');
	}
}
