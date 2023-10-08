<?php

namespace Tests\Feature\Chat;

use App\Models\User;
use Tests\TestCase;

class CreateGroupChatTest extends TestCase
{
    /** @test */

    public function user_can_create_a_chat_with_participant()
    {

        $users = User::factory()->count(10)->create();
        $usersIDs = User::pluck('id')->toArray();
        $chatData = [
            'participantIds' => $usersIDs,
            'group_name' => 'test group'
        ];
        $response = $this->post("/api/create-group-chat", $chatData);
        $response->assertStatus(200);
        return expect($response->getStatusCode())->toEqual(200);
    }
}
