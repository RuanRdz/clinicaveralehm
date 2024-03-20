<?php

Route::group(array('before' => 'auth', 'prefix' => 'dashboard'), function(){

    Route::get('/', array(

        'uses' => 'DashboardController@index',
        'as' => 'dashboard'
    ));
    
    Route::group(array('before' => 'csrf'), function(){
        // 
    });
});

