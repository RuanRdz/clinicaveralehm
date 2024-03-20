<?php

Route::group(array('before' => 'auth', 'prefix' => 'user'), function(){

    Route::get('/', array(

        'uses' => 'UserController@index',
        'as' => 'users'
    ));

    Route::get('/create', array(
        
        'uses' => 'UserController@create',
        'as' => 'userCreate'
    ));

    Route::get('/show/{id}', array(
        
        'uses' => 'UserController@show',
        'as' => 'userShow'
    ));
    
    Route::get('/edit/{id}', array(
        
        'uses' => 'UserController@edit',
        'as' => 'userEdit'
    ));
    
    Route::get('/destroy/{id}', array(
        
        'uses' => 'UserController@destroy',
        'as' => 'userDestroy'
    ));

    Route::get('/destroy-assinatura/{id}', array(
        
        'uses' => 'UserController@destroyAssinatura',
        'as' => 'userDestroyAssinatura'
    ));
    
    Route::get('/regenerate-password/{id}', array(
        
        'uses' => 'UserController@regeneratePassword',
        'as' => 'userRegeneratePassword'
    ));

    Route::group(array('before' => 'csrf'), function(){
        
        Route::post('/store', array(
            
            'uses' => 'UserController@store',
            'as' => 'userStore'
        ));
        
        Route::post('/update/{id}', array(

            'uses' => 'UserController@update',
            'as' => 'userUpdate'
        ));
    });
});

