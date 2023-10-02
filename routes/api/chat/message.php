<?php

use Illuminate\Support\Facades\Route;

Route::group(['namespace' => 'App\Http\Controllers\Chat'], function() {
    Route::post('/send-message', 'MessageController@sendMessage');
});
