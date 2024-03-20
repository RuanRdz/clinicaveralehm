<?php

Route::group(array('before' => 'auth', 'prefix' => 'agendas'), function(){

    Route::match(array('GET', 'POST'), '/', array(

        'uses' => 'AgendasController@index',
        'as' => 'agendas'
    ));

    Route::match(array('GET', 'POST'), '/controle', array(

        'uses' => 'AgendasController@controle',
        'as' => 'agendasControle'
    ));

    Route::get('/create', array(

        'uses' => 'AgendasController@create',
        'as' => 'agendasCreate'
    ));

    Route::get('/show/{id}', array(

        'uses' => 'AgendasController@show',
        'as' => 'agendasShow'
    ));

    Route::get('/edit/{id}', array(

        'uses' => 'AgendasController@edit',
        'as' => 'agendasEdit'
    ));

    Route::get('/edicao-rapida-sessoes/{tratamento_id}', array(

        'uses' => 'AgendasController@edicaoRapidaSessoes',
        'as' => 'agendasEdicaoRapida'
    ));

    Route::get('/destroy/{id}', array(
        
        'uses' => 'AgendasController@destroy',
        'as' => 'agendasDestroy'
    ));

    Route::get('/whatsapp/{id}', array(

        'uses' => 'AgendasController@whatsapp',
        'as' => 'agendasWhatsapp'
    ));

    Route::post('/ordenar-sessoes', array(

        'uses' => 'AgendasController@ordenarSessoes',
        'as' => 'agendasOrdenarSessoes'
    ));

    Route::post('/consultar-sessoes', array(

        'uses' => 'AgendasController@consultarSessoes',
        'as' => 'agendasConsultarSessoes'
    ));


    /* BLOQUEIO */
    Route::get('/create-bloqueio', array(

        'uses' => 'AgendasController@createBloqueio',
        'as' => 'agendasCreateBloqueio'
    ));

    Route::get('/edit-bloqueio/{id}', array(

        'uses' => 'AgendasController@editBloqueio',
        'as' => 'agendasEditBloqueio'
    ));

    Route::get('/delete-bloqueio/{id}', array(

        'uses' => 'AgendasController@destroyBloqueio',
        'as' => 'agendasDestroyBloqueio'
    ));

    /* AGENDAMENTO */
    Route::get('/create-agendamento', array(

        'uses' => 'AgendasController@createAgendamento',
        'as' => 'agendasCreateAgendamento'
    ));

    Route::get('/edit-agendamento/{id}', array(

        'uses' => 'AgendasController@editAgendamento',
        'as' => 'agendasEditAgendamento'
    ));

    Route::get('/delete-agendamento/{id}', array(

        'uses' => 'AgendasController@destroyAgendamento',
        'as' => 'agendasDestroyAgendamento'
    ));

    Route::post('/update-status-multiple-sessions', array(

        'uses' => 'AgendasController@updateStatusMultipleSessions',
        'as' => 'agendasUpdateStatusMultipleSessions'
    ));

    Route::group(array('before' => 'csrf'), function(){

        Route::post('/store', array(

            'uses' => 'AgendasController@store',
            'as' => 'agendasStore'
        ));
        Route::post('/update/{id}', array(

            'uses' => 'AgendasController@update',
            'as' => 'agendasUpdate'
        ));
        Route::post('/update-edicao-rapida-sessoes/{tratamento_id}', array(

            'uses' => 'AgendasController@updateEdicaoRapidaSessoes',
            'as' => 'agendasUpdateEdicaoRapidaSessoes'
        ));


        Route::post('/store-bloqueio', array(

            'uses' => 'AgendasController@storeBloqueio',
            'as' => 'agendasStoreBloqueio'
        ));
        Route::post('/update-bloqueio/{id}', array(

            'uses' => 'AgendasController@updateBloqueio',
            'as' => 'agendasUpdateBloqueio'
        ));


        Route::post('/store-agendamento', array(

            'uses' => 'AgendasController@storeAgendamento',
            'as' => 'agendasStoreAgendamento'
        ));
        Route::post('/update-agendamento/{id}', array(

            'uses' => 'AgendasController@updateAgendamento',
            'as' => 'agendasUpdateAgendamento'
        ));
    });
});
