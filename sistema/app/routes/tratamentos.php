<?php

Route::group(array('before' => 'auth', 'prefix' => 'tratamentos'), function(){

    Route::match(array('GET', 'POST'), '/', array(

        'uses' => 'TratamentosController@index',
        'as' => 'tratamentos'
    ));

    Route::get('/create/{id}', array(

        'uses' => 'TratamentosController@create',
        'as' => 'tratamentosCreate'
    ));

    Route::get('/show/{id}/{layout}', array(

        'uses' => 'TratamentosController@show',
        'as' => 'tratamentosShow'
    ));

    Route::get('/edit/{id}', array(

        'uses' => 'TratamentosController@edit',
        'as' => 'tratamentosEdit'
    ));

    Route::get('/destroy/{id}', array(

        'uses' => 'TratamentosController@destroy',
        'as' => 'tratamentosDestroy'
    ));

    Route::get('/restore/{id}', array(

        'uses' => 'TratamentosController@restore',
        'as' => 'tratamentosRestore'
    ));

    Route::get('/alterar-valores/{id}', array(

        'uses' => 'TratamentosController@formAlterarValores',
        'as' => 'tratamentosFormAlterarValores'
    ));

    Route::get('/showlaudo/{id}', array(

        'uses' => 'TratamentosController@showLaudo',
        'as' => 'tratamentosLaudo'
    ));
    Route::get('/editlaudo/{id}', array(

        'uses' => 'TratamentosController@editLaudo',
        'as' => 'tratamentosEditLaudo'
    ));

    Route::post('/sendemail/{id}', array(

        'uses' => 'TratamentosController@sendEmail',
        'as' => 'tratamentosSendEmail'
    ));
    Route::get('/faturar/{id}', array(

        'uses' => 'TratamentosController@faturar',
        'as' => 'tratamentosFaturar'
    ));
    Route::get('/comboboxAtendimento/{workspace_id}', array(

        'uses' => 'TratamentosController@comboboxAtendimento',
        'as' => 'tratamentosComboboxAtendimento'
    ));

    Route::group(array('before' => 'csrf'), function(){

        Route::post('/store', array(

            'uses' => 'TratamentosController@store',
            'as' => 'tratamentosStore'
        ));

        Route::post('/update/{id}', array(

            'uses' => 'TratamentosController@update',
            'as' => 'tratamentosUpdate'
        ));

        Route::post('/updatelaudo/{id}', array(

            'uses' => 'TratamentosController@updateLaudo',
            'as' => 'tratamentosUpdateLaudo'
        ));

        Route::post('/alterar-valores/{id}', array(

            'uses' => 'TratamentosController@updateAlterarValores',
            'as' => 'tratamentosUpdateAlterarValores'
        ));
    });
});
