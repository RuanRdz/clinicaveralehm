<?php

Route::group(array(
    'before' => 'auth',
    'prefix' => 'avds',
), function(){

    Route::get('edit/{id}', array(

        'uses' => 'AvdsController@edit',
        'as' => 'avdsEdit'
    ));

    Route::group(array('before' => 'csrf'), function(){

        Route::post('update', array(

            'uses' => 'AvdsController@update',
            'as' => 'avdsUpdate'
        ));
    });
});
