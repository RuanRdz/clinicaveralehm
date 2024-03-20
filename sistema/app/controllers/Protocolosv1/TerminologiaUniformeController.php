<?php

class TerminologiaUniformeController extends BaseRelatorioController {

	public function edit($id)
	{
		User::allowedCredentials(array(10, 20));
		$t = Tratamento::findOrFail($id);

		$terminologias = Terminologia::all()->toArray();
		$dados = $t->terminologias->lists('id');
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
        $action = route('terminologiauniformeUpdate', array('id' => $t->id));
        return View::make('protocolos.terminologiauniforme.form', compact('t', 'tree', 'action'));
	}

	public function update($id)
	{
		User::allowedCredentials(array(10, 20));
		$tratamento = Tratamento::findOrFail($id);
		$tratamento->terminologias()->sync(Input::get('terminologia_tratamento'));
		$tratamento->setFezAvaliacao();
		return Redirect::back()->with('success', 'Cadastro atualizado.');
	}
}
