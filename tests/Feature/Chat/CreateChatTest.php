<?php

namespace Tests\Feature\Chat;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class CreateChatTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function user_can_create_a_chat_with_participants()
    {
        $otherUsers = User::factory()->count(2)->create();

        $userIds = $otherUsers->pluck('id')->toArray();

        // Data for the chat to be created
        $chatData = [
            'users' => $userIds  // Passing user IDs to the API endpoint
        ];

        $response = $this->postJson("/api/create-chat", $chatData);

        // Then: The API should respond with the chat details and status 201
        $response->assertStatus(201)
            ->assertJson([
                'id' => 'chat id'
            ]);

        // Also, verify that the chat exists in the database with the given users
        $createdChatId = $response->json('id');
        $this->assertDatabaseHas('acc_com_chats', ['id' => $createdChatId]);
        foreach ($userIds as $userId) {
            $this->assertDatabaseHas('acc_com_participants', ['chat_id' => $createdChatId, 'user_id' => $userId]);
        }
    }
}
