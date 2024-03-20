<?php

Route::group(array('before' => 'auth', 'prefix' => 'workspaces'), function(){

    Route::get('/', array(

        'uses' => 'WorkspacesController@index',
        'as' => 'workspaces'
    ));

    Route::get('/create', array(

        'uses' => 'WorkspacesController@create',
        'as' => 'workspacesCreate'
    ));

    Route::get('/edit/{id}', array(

        'uses' => 'WorkspacesController@edit',
        'as' => 'workspacesEdit'
    ));

    Route::get('/destroy/{id}', array(

        'uses' => 'WorkspacesController@destroy',
        'as' => 'workspacesDestroy'
    ));

    Route::get('/setCurrent/{id}', array(

        'uses' => 'WorkspacesController@setCurrent',
        'as' => 'setCurrentWorkspace'
    ));

    Route::group(array('before' => 'csrf'), function(){

        Route::post('/store', array(

            'uses' => 'WorkspacesController@store',
            'as' => 'workspacesStore'
        ));

        Route::post('/update/{id}', array(

            'uses' => 'WorkspacesController@update',
            'as' => 'workspacesUpdate'
        ));
    });
});

