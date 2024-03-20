<?php

Route::pattern('id', '[0-9]+');
Route::pattern('id2', '[0-9]+');
Route::pattern('letra', '[A-Z]');

// Load route files from app/routes
foreach (File::allFiles(__DIR__.'/routes') as $partial) {

	require_once $partial->getPathName();
}
