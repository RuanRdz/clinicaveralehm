<?php

Route::group(array(
    'before' => 'auth',
    'prefix' => 'atividades',
), function(){

    // Route::get('{id}', array(

    //     'uses' => 'AtividadesController@index',
    //     'as' => 'atividades'
    // ));

    Route::get('edit/{id}', array(

        'uses' => 'AtividadesController@edit',
        'as' => 'atividadesEdit'
    ));

    Route::group(array('before' => 'csrf'), function(){

        Route::post('update', array(

            'uses' => 'AtividadesController@update',
            'as' => 'atividadesUpdate'
        ));
    });
});
