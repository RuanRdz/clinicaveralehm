<?php

Route::group(array('before' => 'auth', 'prefix' => 'bancos'), function(){

    Route::get('/', array(

        'uses' => 'BancosController@index',
        'as' => 'bancos'
    ));

    Route::get('/create', array(
        
        'uses' => 'BancosController@create',
        'as' => 'bancosCreate'
    ));

    Route::get('/show/{id}', array(
        
        'uses' => 'BancosController@show',
        'as' => 'bancosShow'
    ));
    
    Route::get('/edit/{id}', array(
        
        'uses' => 'BancosController@edit',
        'as' => 'bancosEdit'
    ));
    
    Route::get('/destroy/{id}', array(
        
        'uses' => 'BancosController@destroy',
        'as' => 'bancosDestroy'
    ));
    
    Route::group(array('before' => 'csrf'), function(){
        
        Route::post('/store', array(
            
            'uses' => 'BancosController@store',
            'as' => 'bancosStore'
        ));
        
        Route::post('/update/{id}', array(

            'uses' => 'BancosController@update',
            'as' => 'bancosUpdate'
        ));
    });
});

