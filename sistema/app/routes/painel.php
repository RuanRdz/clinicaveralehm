<?php

/* Painel geral do paciente */

Route::group(array('before' => 'auth', 'prefix' => 'painel'), function(){

    /**
     * id  = paciente id
     * id2 = tratamento id
     */
    Route::get('/{id}/{id2?}', array(

        'uses' => 'PainelController@index',
        'as' => 'painel'
    ));
});
