<?php

Route::group(array('before' => 'auth', 'prefix' => 'convenios'), function(){

    Route::get('/', array(

        'uses' => 'ConveniosController@index',
        'as' => 'convenios'
    ));

    Route::get('/create', array(
        
        'uses' => 'ConveniosController@create',
        'as' => 'conveniosCreate'
    ));

    Route::get('/show/{id}', array(
        
        'uses' => 'ConveniosController@show',
        'as' => 'conveniosShow'
    ));
    
    Route::get('/edit/{id}', array(
        
        'uses' => 'ConveniosController@edit',
        'as' => 'conveniosEdit'
    ));
    
    Route::get('/destroy/{id}', array(
        
        'uses' => 'ConveniosController@destroy',
        'as' => 'conveniosDestroy'
    ));
    
    Route::group(array('before' => 'csrf'), function(){
        
        Route::post('/store', array(
            
            'uses' => 'ConveniosController@store',
            'as' => 'conveniosStore'
        ));
        
        Route::post('/update/{id}', array(

            'uses' => 'ConveniosController@update',
            'as' => 'conveniosUpdate'
        ));
    });
});

