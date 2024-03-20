<?php

Route::group(array('before' => 'auth', 'prefix' => 'centrocusto'), function(){

    Route::get('/', array(

        'uses' => 'CentrocustoController@index',
        'as' => 'centrocusto'
    ));

    Route::get('/create', array(
        
        'uses' => 'CentrocustoController@create',
        'as' => 'centrocustoCreate'
    ));

    Route::get('/show/{id}', array(
        
        'uses' => 'CentrocustoController@show',
        'as' => 'centrocustoShow'
    ));
    
    Route::get('/edit/{id}', array(
        
        'uses' => 'CentrocustoController@edit',
        'as' => 'centrocustoEdit'
    ));
    
    Route::get('/destroy/{id}', array(
        
        'uses' => 'CentrocustoController@destroy',
        'as' => 'centrocustoDestroy'
    ));
    
    Route::group(array('before' => 'csrf'), function(){
        
        Route::post('/store', array(
            
            'uses' => 'CentrocustoController@store',
            'as' => 'centrocustoStore'
        ));
        
        Route::post('/update/{id}', array(

            'uses' => 'CentrocustoController@update',
            'as' => 'centrocustoUpdate'
        ));
    });
});

