<?php

Route::group(array('before' => 'auth', 'prefix' => 'documentos'), function(){

    Route::get('/', array(

        'uses' => 'DocumentosController@index',
        'as' => 'documentos'
    ));

    Route::get('/create', array(
        
        'uses' => 'DocumentosController@create',
        'as' => 'documentosCreate'
    ));

    Route::get('/show/{id}', array(
        
        'uses' => 'DocumentosController@show',
        'as' => 'documentosShow'
    ));
    
    Route::get('/edit/{id}', array(
        
        'uses' => 'DocumentosController@edit',
        'as' => 'documentosEdit'
    ));
    
    Route::get('/destroy/{id}', array(
        
        'uses' => 'DocumentosController@destroy',
        'as' => 'documentosDestroy'
    ));
    
    Route::group(array('before' => 'csrf'), function(){
        
        Route::post('/store', array(
            
            'uses' => 'DocumentosController@store',
            'as' => 'documentosStore'
        ));
        
        Route::post('/update/{id}', array(

            'uses' => 'DocumentosController@update',
            'as' => 'documentosUpdate'
        ));
    });
});

