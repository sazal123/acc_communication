<?php

namespace Tests\Feature\Chat;

use App\Models\User;
use Tests\TestCase;

class DeleteChatTest extends TestCase
{
    /** @test */
    public function user_can_delete_chat()
    {
        $chatData = [
            'chatId' => env('CHAT_ID_ONE_TO_ONE')
        ];
        $response = $this->post("api/delete-chat", $chatData);
        return expect($response->getStatusCode())->toEqual(200);
    }
}
