<?php

use Illuminate\Support\Facades\Route;

Route::group(['namespace' => 'App\Http\Controllers\Chat'], function() {
    Route::post('/create-chat', 'ChatController@createChat');
    Route::post('/create-group-chat', 'ChatController@createGroupChat');
});
