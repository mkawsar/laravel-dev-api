<?php

use Illuminate\Support\Facades\Route;

Route::group([
    'namespace' => 'Api',
    'prefix' => 'auth'
], function () {
    Route::post('login', 'AuthController@login');
});
Route::group([
    'namespace' => 'Api',
    'prefix' => 'auth',
    'middleware' => ['auth:api']
], function () {
    Route::get('user/logout', 'AuthController@logout');
});
