<?php

namespace Tests\Feature\Chat;

use App\Models\User;
use Tests\TestCase;

class DeleteGroupChatTest extends TestCase
{
    /** @test */
    public function user_can_delete_chat()
    {
        $chatData = [
            'chatId' => env('CHAT_ID_GROUP')
        ];
        $response = $this->post("api/delete-group-chat", $chatData);
        return expect($response->getStatusCode())->toEqual(200);
    }
}
