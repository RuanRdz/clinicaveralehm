<?php

Route::group(array(
    'before' => 'auth',
    'prefix' => 'relatorio',
), function(){

    Route::get('{id}', array(

        'uses' => 'RelatorioController@index',
        'as' => 'relatorio'
    ));

    Route::get('edit/{id}', array(

        'uses' => 'RelatorioController@edit',
        'as' => 'relatorioEdit'
    ));

    Route::group(array('before' => 'csrf'), function(){

        Route::post('update', array(

            'uses' => 'RelatorioController@update',
            'as' => 'relatorioUpdate'
        ));
    });
});
