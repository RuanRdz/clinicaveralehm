<?php

Route::group(array('before' => 'auth', 'prefix' => 'tabelaforca'), function(){

    Route::get('index/{id}', array(

        'uses' => 'TabelaforcaController@index',
        'as' => 'tabelaforcaIndex'
    ));

    Route::get('create/{id}', array(

        'uses' => 'TabelaforcaController@create',
        'as' => 'tabelaforcaCreate'
    ));

    Route::get('edit/{id}', array(

        'uses' => 'TabelaforcaController@edit',
        'as' => 'tabelaforcaEdit'
    ));

    Route::get('destroy/{id}', array(

        'uses' => 'TabelaforcaController@destroy',
        'as' => 'tabelaforcaDestroy'
    ));

    Route::group(array('before' => 'csrf'), function(){

        Route::post('store', array(

            'uses' => 'TabelaforcaController@store',
            'as' => 'tabelaforcaStore'
        ));

        Route::post('update/{id}', array(

            'uses' => 'TabelaforcaController@update',
            'as' => 'tabelaforcaUpdate'
        ));
    });
});
