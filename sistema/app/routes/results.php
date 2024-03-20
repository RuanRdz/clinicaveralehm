<?php

Route::group(array('before' => 'auth', 'prefix' => 'results'), function(){

    Route::get('/{chart?}', array(

        'uses' => 'ResultsController@index',
        'as' => 'results'
    ));

    Route::group(array('before' => 'csrf'), function(){
        // 
    });
});

