<?php

Route::group(array('before' => 'auth', 'prefix' => 'configuracoes'), function(){

    Route::get('/', array(

        'uses' => 'SistemaController@index',
        'as' => 'sistema'
    ));

    Route::get('/terminologia', array(

        'uses' => 'SistemaController@terminologia',
        'as' => 'sistemaTerminologia'
    ));

    Route::get('/terminologiacreate', array(

        'uses' => 'SistemaController@terminologiaCreate',
        'as' => 'sistemaTerminologiaCreate'
    ));

    Route::get('/terminologiaedit/{id}', array(

        'uses' => 'SistemaController@terminologiaEdit',
        'as' => 'sistemaTerminologiaEdit'
    ));

    Route::group(array('before' => 'csrf'), function(){

        Route::post('/update', array(

            'uses' => 'SistemaController@update',
            'as' => 'sistemaUpdate'
        ));

        Route::post('/terminologiastore', array(

            'uses' => 'SistemaController@terminologiaStore',
            'as' => 'sistemaTerminologiaStore'
        ));

        Route::post('/terminologiaupdate/{id}', array(

            'uses' => 'SistemaController@terminologiaUpdate',
            'as' => 'sistemaTerminologiaUpdate'
        ));
    });
});
