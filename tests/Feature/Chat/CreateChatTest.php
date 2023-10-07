<?php

namespace Tests\Feature\Chat;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Log;
use Tests\TestCase;
use Exception;

class CreateChatTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function user_can_create_a_chat_with_participant()
    {

        $otherUsers = User::factory()->count(10)->create();
        $userIds = $otherUsers->pluck('id')->toArray();
        $chatData = [
            'participantId' => 7
        ];
        $response = $this->post("api/create-chat", $chatData);
        $response->assertStatus(200);

    }
}
