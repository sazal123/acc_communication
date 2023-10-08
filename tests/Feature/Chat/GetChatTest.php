<?php

namespace Tests\Feature\Chat;

use App\Models\Chat\Chat;
use App\Models\User;
use Tests\TestCase;

class GetChatTest extends TestCase
{
    /** @test */
    public function user_can_retrieve_chat_list()
    {
        $user = User::factory()->create();
        $chat = Chat::factory()->create();

        $response = $this->get("/api/get-chat");
        $response->assertStatus(200)
            ->assertJson([
                'id' => $chat->id,
            ]);
    }
}
