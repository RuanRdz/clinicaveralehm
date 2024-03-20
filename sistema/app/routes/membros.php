<?php

Route::group(array('before' => 'auth', 'prefix' => 'membros'), function(){

    Route::get('/', array(

        'uses' => 'MembrosController@index',
        'as' => 'membros'
    ));

    Route::get('/create', array(
        
        'uses' => 'MembrosController@create',
        'as' => 'membrosCreate'
    ));

    Route::get('/show/{id}', array(
        
        'uses' => 'MembrosController@show',
        'as' => 'membrosShow'
    ));
    
    Route::get('/edit/{id}', array(
        
        'uses' => 'MembrosController@edit',
        'as' => 'membrosEdit'
    ));
    
    Route::get('/destroy/{id}', array(
        
        'uses' => 'MembrosController@destroy',
        'as' => 'membrosDestroy'
    ));
    
    Route::group(array('before' => 'csrf'), function(){
        
        Route::post('/store', array(
            
            'uses' => 'MembrosController@store',
            'as' => 'membrosStore'
        ));
        
        Route::post('/update/{id}', array(

            'uses' => 'MembrosController@update',
            'as' => 'membrosUpdate'
        ));
    });
});

