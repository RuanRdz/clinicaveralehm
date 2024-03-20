<?php

Route::group(array('before' => 'auth', 'prefix' => 'terminologiauniformeconfig'), function(){

    Route::get('/', array(

        'uses' => 'TerminologiaUniformeConfigController@index',
        'as' => 'terminologiauniformeconfig'
    ));

    Route::get('/create', array(
        
        'uses' => 'TerminologiaUniformeConfigController@create',
        'as' => 'terminologiauniformeconfigCreate'
    ));

    Route::get('/show/{id}', array(
        
        'uses' => 'TerminologiaUniformeConfigController@show',
        'as' => 'terminologiauniformeconfigShow'
    ));
    
    Route::get('/edit/{id}', array(
        
        'uses' => 'TerminologiaUniformeConfigController@edit',
        'as' => 'terminologiauniformeconfigEdit'
    ));
    
    Route::get('/destroy/{id}', array(
        
        'uses' => 'TerminologiaUniformeConfigController@destroy',
        'as' => 'terminologiauniformeconfigDestroy'
    ));
    
    Route::group(array('before' => 'csrf'), function(){
        
        Route::post('/store', array(
            
            'uses' => 'TerminologiaUniformeConfigController@store',
            'as' => 'terminologiauniformeconfigStore'
        ));
        
        Route::post('/update/{id}', array(

            'uses' => 'TerminologiaUniformeConfigController@update',
            'as' => 'terminologiauniformeconfigUpdate'
        ));
    });
});

