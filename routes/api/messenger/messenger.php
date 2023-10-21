<?php
use Illuminate\Support\Facades\Route;
Route::group(['namespace' => 'App\Http\Controllers\Messenger'], function() {
    Route::post('/webhook', 'FacebookWebhookController@handleWebhook');
    Route::get('/webhook', 'FacebookWebhookController@verifyWebhook');
    Route::get('/get-conversations-list', 'FacebookWebhookController@getConversationsList');
});

