<?php

Route::group(array(
    'before' => 'auth',
    'prefix' => 'report',
), function(){

    Route::get('/{treatment_id}', array(

        'uses' => 'ReportController@index',
        'as' => 'report'
    ));

    
    Route::group(array('before' => 'csrf'), function(){
        
        Route::post('/update', array(
    
            'uses' => 'ReportController@update',
            'as' => 'reportUpdate'
        ));
    });
});
