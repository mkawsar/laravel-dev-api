<?php

use Illuminate\Support\Facades\Route;

Route::group([
    'namespace' => 'Api',
    'middleware' => ['auth:api']
], function () {
    Route::resource('product', 'ProductController', [
        'only' => ['index', 'store', 'destroy', 'show']
    ]);
    Route::post('product/{productID}', 'ProductController@update');
});
