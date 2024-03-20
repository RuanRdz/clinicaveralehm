<?php

Route::group(array('before' => 'auth', 'prefix' => 'financeiro'), function(){

    // Movimentação

    Route::match(array('GET', 'POST'), '/', array(

        'uses' => 'MovimentacaoController@index',
        'as' => 'financeiroMovimentacao'
    ));

    Route::post('/movimentacao-json', array(

        'uses' => 'MovimentacaoController@movimentacaoJson',
        'as' => 'financeiroMovimentacaoJson'
    ));

    Route::get('/movimentacao-excel', array(

        'uses' => 'MovimentacaoController@excel',
        'as' => 'financeiroMovimentacaoExcel'
    ));

    // Fluxo de caixa

    Route::match(array('GET', 'POST'), '/fluxo-de-caixa', array(

        'uses' => 'FluxoController@index',
        'as' => 'financeiroFluxo'
    ));

    Route::get('/fluxo-de-caixa-excel', array(

        'uses' => 'FluxoController@excel',
        'as' => 'financeiroFluxoExcel'
    ));

    // Saldo

    Route::match(array('GET', 'POST'), '/saldo', array(

        'uses' => 'SaldoController@index',
        'as' => 'financeiroSaldo'
    ));

    Route::get('/saldo-excel', array(

        'uses' => 'SaldoController@excel',
        'as' => 'financeiroSaldoExcel'
    ));

    Route::get('/processar-saldo', array(

        'uses' => 'SaldoController@processar',
        'as' => 'financeiroProcessarSaldo'
    ));
    
    // Conciliação
    
    Route::get('/conciliacao', array(

        'uses' => 'ConciliacaoController@index',
        'as' => 'financeiroConciliacao'
    ));

    Route::post('/conciliacao', array(

        'uses' => 'ConciliacaoController@upload',
        'as' => 'financeiroConciliacaoUpload'
    ));
    
    // Lotes

    Route::get('/lista-itens-lote/{id}', array(

        'uses' => 'MovimentacaoController@listarItensLote',
        'as' => 'financeiroListarItensLote'
    ));

    // Produção Profissionais

    Route::match(array('GET', 'POST'), '/producao', array(

        'uses' => 'ProducaoController@index',
        'as' => 'financeiroProducao'
    ));


    // Actions

    Route::get('/destroy/{id}', array(

        'uses' => 'MovimentacaoController@destroy',
        'as' => 'financeiroDestroy'
    ));

    Route::get('/duplicate/{id}', array(

        'uses' => 'MovimentacaoController@duplicate',
        'as' => 'financeiroDuplicate'
    ));

    Route::match(array('GET', 'POST'), '/update-pagamento', array(

        'uses' => 'MovimentacaoController@updatePagamentoListagem',
        'as' => 'updatePagamento'
    ));

    Route::post('/simular-parcelamento', array(

        'uses' => 'MovimentacaoController@simularParcelamento',
        'as' => 'financeiroSimularParcelamento'
    ));

    Route::post('/transferencia-contas', array(

        'uses' => 'MovimentacaoController@financeiroTransferenciaContas',
        'as' => 'financeiroTransferenciaContas'
    ));

    Route::get('/gerar-recibo/{id}', array(

        'uses' => 'BasefinanceiroController@gerarRecibo',
        'as' => 'financeiroGerarRecibo'
    ));
});
