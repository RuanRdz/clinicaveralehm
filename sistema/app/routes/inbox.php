<?php

Route::group(array('before' => 'auth', 'prefix' => 'inbox'), function(){

    Route::get('/{id?}', array(

        'uses' => 'InboxController@index',
        'as' => 'inbox'
    ));

    Route::get('/create', array(

        'uses' => 'InboxController@create',
        'as' => 'inboxCreate'
    ));


    Route::get('/destroy/{id}', array(

        'uses' => 'InboxController@destroy',
        'as' => 'inboxDestroy'
    ));

    Route::get('/visualizado/{id}/{letra}', array(

        'uses' => 'InboxController@visualizado',
        'as' => 'inboxVisualizado'
    ));

    Route::get('/situacao/{id}/{opcao}', array(

        'uses' => 'InboxController@situacao',
        'as' => 'inboxSituacao'
    ));

    Route::group(array('before' => 'csrf'), function(){

        Route::post('/store', array(

            'uses' => 'InboxController@store',
            'as' => 'inboxStore'
        ));
    });
});
