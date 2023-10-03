<?php

use Illuminate\Support\Facades\Route;

Route::group(['namespace' => 'App\Http\Controllers\Chat'], function() {
    Route::post('/create-chat', 'ChatController@createChat');
    Route::post('/create-group-chat', 'ChatController@createGroupChat');
    Route::post('/delete-chat', 'ChatController@deleteChat');
    Route::post('/delete-group-chat', 'ChatController@deleteGroupChat');
    Route::get('/get-chat', 'ChatController@getChat');
    Route::post('/add-user-to-chat', 'ChatController@addUserToChat');
});
