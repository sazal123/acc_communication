<?php

namespace Tests\Feature\Chat;

use App\Models\User;
use Tests\TestCase;

class CreateChatTest extends TestCase
{
    /** @test */
    public function user_can_create_a_chat_with_participant()
    {

        $users = User::factory()->count(10)->create();
        $usersIDs = User::pluck('id')->toArray();
        $random_id = array_rand($usersIDs);
        $chatData = [
            'participantId' => $usersIDs[$random_id]
        ];
        $response = $this->post("api/create-chat", $chatData);
        return expect($response->getStatusCode())->toEqual(200);
    }
}
