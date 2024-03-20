<?php

Route::group(array(
    'before' => 'auth',
    'prefix' => 'mapeamentosensorial',
), function(){

    Route::get('edit/{id}', array(

        'uses' => 'MapeamentoSensorialController@edit',
        'as' => 'mapeamentosensorialEdit'
    ));

    Route::group(array('before' => 'csrf'), function(){

        Route::post('update', array(

            'uses' => 'MapeamentoSensorialController@update',
            'as' => 'mapeamentosensorialUpdate'
        ));
    });
});
