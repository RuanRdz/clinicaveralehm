<?php

Route::group(array('before' => 'auth', 'prefix' => 'conveniotipos'), function(){

    Route::get('/', array(

        'uses' => 'ConveniotiposController@index',
        'as' => 'conveniotipos'
    ));

    Route::get('/create', array(
        
        'uses' => 'ConveniotiposController@create',
        'as' => 'conveniotiposCreate'
    ));

    Route::get('/show/{id}', array(
        
        'uses' => 'ConveniotiposController@show',
        'as' => 'conveniotiposShow'
    ));
    
    Route::get('/edit/{id}', array(
        
        'uses' => 'ConveniotiposController@edit',
        'as' => 'conveniotiposEdit'
    ));
    
    Route::get('/destroy/{id}', array(
        
        'uses' => 'ConveniotiposController@destroy',
        'as' => 'conveniotiposDestroy'
    ));
    
    Route::group(array('before' => 'csrf'), function(){
        
        Route::post('/store', array(
            
            'uses' => 'ConveniotiposController@store',
            'as' => 'conveniotiposStore'
        ));
        
        Route::post('/update/{id}', array(

            'uses' => 'ConveniotiposController@update',
            'as' => 'conveniotiposUpdate'
        ));
    });
});

