<?php

// Autocomplete Route
Route::post('/autocomplete', function(){

    // Post params
    $model_name  = Input::get('model_name');
    $term        = filter_var(Input::get('term'), FILTER_SANITIZE_STRING);

    $result = [];
    switch ($model_name) {

        case 'cidade':
            $query = Cidade::autocomplete($term);
            foreach($query as $row)
                $result[] = array(
                    'id'    => $row->id,
                    'label' => $row->nome.' - '.$row->estado_uf,
                );
            break;

        case 'paciente':
            $query = Paciente::autocomplete($term);
            foreach($query as $row)
                $result[] = array(
                    'id'    => $row->id,
                    'label' => $row->nome,
                );
            break;

        case 'lesao':
            $query = Lesao::autocomplete($term);
            foreach($query as $row)
                $result[] = array(
                    'id'    => $row->id,
                    'label' => $row->nome,
                );
            break;

        case 'membro':
            $query = Membro::autocomplete($term);
            foreach($query as $row)
                $result[] = array(
                    'id'    => $row->id,
                    'label' => $row->nome,
                );
            break;

        case 'medico':
            $query = Medico::autocomplete($term);
            foreach($query as $row)
                $result[] = array(
                    'id'    => $row->id,
                    'label' => $row->nome,
                );
            break;

        case 'convenio':
            $query = Convenio::autocomplete($term);
            foreach($query as $row){
                $cidade = '';
                if ($row->cidade_id) {
                    $cidade = ' - '.$row->cidade->nome.' / '.$row->cidade->estado_uf;
                }
                $result[] = array(
                    'id'    => $row->id,
                    'label' => $row->nome.$cidade,
                    'valor' => $row->valor,
                );
            }
            break;

        case 'fornecedor':
            $query = Fornecedor::autocomplete($term);
            foreach($query as $row)
                $result[] = array(
                    'id'    => $row->id,
                    'label' => $row->nome,
                );
            break;

        case 'testeforca':
            $query = Testeforca::autocomplete($term);
            foreach($query as $row)
                $result[] = array(
                    'id'    => $row->id,
                    'label' => $row->nome,
                );
            break;
    }
    return Response::json($result);
});
