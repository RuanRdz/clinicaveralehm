<?php

// Namespaces
$nsP = '\\app\\controllers\\Protocols';
$nsT = '\\app\\controllers\\Protocols\\Tests';

Route::group(array(
		'before' => 'auth',
		'prefix' => 'protocols',
), function() use($nsP, $nsT) {

	// Protocols Admin
	Route::get('', array(
		'uses' => $nsP.'\ProtocolsController@index', 'as' => 'protocols.index'
	));
	Route::get('create', array(
		'uses' => $nsP.'\ProtocolsController@create', 'as' => 'protocols.create'
	));
	Route::get('edit/{id}', array(
		'uses' => $nsP.'\ProtocolsController@edit', 'as' => 'protocols.edit'
	));
	Route::group(array('before' => 'csrf'), function() use($nsP) {
		Route::post('store', array(
			'uses' => $nsP.'\ProtocolsController@store', 'as' => 'protocols.store'
		));
		Route::post('update/{id}', array(
			'uses' => $nsP.'\ProtocolsController@update', 'as' => 'protocols.update'
		));
	});

	// Tests Admin
	Route::group(array('prefix' => 'tests'), function() use($nsP, $nsT) {

		Route::get('create', array(
			'uses' => $nsP.'\TestsController@create', 'as' => 'tests.create'
		));
		Route::get('edit/{id}', array(
			'uses' => $nsP.'\TestsController@edit', 'as' => 'tests.edit'
		));
		Route::group(array('before' => 'csrf'), function() use($nsP) {
			Route::post('store', array(
					'uses' => $nsP.'\TestsController@store', 'as' => 'tests.store'
			));
			Route::post('update/{id}', array(
					'uses' => $nsP.'\TestsController@update', 'as' => 'tests.update'
			));
		});


		// Build Test Routes
		$tests = Schema::hasTable('tests') ? app\models\Protocols\Test::all() : [];

		foreach ($tests as $test) {

			$ns = $test->namespace;
			$nsSlug = $test->getRoutePrefix();

			foreach ($test->extractControllers() as $controller => $controllerRoute) {

				$uri = $nsSlug.'-'.$controllerRoute;
				$routePrefix = $nsSlug.'.'.$controllerRoute;

				switch ($controllerRoute) {

					case 'data':

						Route::group(
							array('prefix' => $uri),
							function() use($nsT, $ns, $controller, $routePrefix) {

							Route::get('index/{treatment_id}', array(
								'uses' => $nsT.'\\'.$ns.'\\'.$controller.'@index',
								'as'   => $routePrefix.'.index'
							));
							Route::get('create/{treatment_id}', array(
								'uses' => $nsT.'\\'.$ns.'\\'.$controller.'@create',
								'as'   => $routePrefix.'.create'
							));
							Route::get('edit/{id}', array(
								'uses' => $nsT.'\\'.$ns.'\\'.$controller.'@edit',
								'as'   => $routePrefix.'.edit'
							));
							Route::get('destroy/{id}', array(
								'uses' => $nsT.'\\'.$ns.'\\'.$controller.'@destroy',
								'as'   => $routePrefix.'.destroy'
							));
							Route::get('destroy-by-date/{treatment_id}/{date}', array(
								'uses' => $nsT.'\\'.$ns.'\\'.$controller.'@destroyByDate',
								'as'   => $routePrefix.'.destroy-by-date'
							));

							Route::group(
								array('before' => 'csrf'),
								function() use($nsT, $ns, $controller,  $routePrefix) {

								Route::post('store', array(
									'uses' => $nsT.'\\'.$ns.'\\'.$controller.'@store',
									'as'   => $routePrefix.'.store'
								));

								Route::post('update', array(
									'uses' => $nsT.'\\'.$ns.'\\'.$controller.'@update',
									'as'   => $routePrefix.'.update'
								));
							});
						});

						break;

					// case 'paramgroup':
					// case 'param':
					// case 'scale':

					default: 

						Route::group(
							array('prefix' => $uri),
							function() use($nsT, $ns, $controller, $routePrefix) {

							Route::get('index', array(
								'uses' => $nsT.'\\'.$ns.'\\'.$controller.'@index',
								'as'   => $routePrefix.'.index'
							));
							Route::get('create', array(
								'uses' => $nsT.'\\'.$ns.'\\'.$controller.'@create',
								'as'   => $routePrefix.'.create'
							));
							Route::get('edit/{id}', array(
								'uses' => $nsT.'\\'.$ns.'\\'.$controller.'@edit',
								'as'   => $routePrefix.'.edit'
							));
							Route::get('destroy/{id}', array(
								'uses' => $nsT.'\\'.$ns.'\\'.$controller.'@destroy',
								'as'   => $routePrefix.'.destroy'
							));

							Route::group(
								array('before' => 'csrf'),
								function() use($nsT, $ns, $controller,  $routePrefix) {

								Route::post('store', array(
									'uses' => $nsT.'\\'.$ns.'\\'.$controller.'@store',
									'as'   => $routePrefix.'.store'
								));
								Route::post('update/{id}', array(
									'uses' => $nsT.'\\'.$ns.'\\'.$controller.'@update',
									'as'   => $routePrefix.'.update'
								));
							});
						});

						break;

				}

			}
		}
	});
});
