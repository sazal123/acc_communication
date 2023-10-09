<?php

namespace Tests\Feature\Chat;

use App\Models\Chat\Chat;
use App\Models\Chat\Group;
use App\Models\Chat\Participant;
use App\Models\User;
use Tests\TestCase;

class RemoveUserFromChatTest extends TestCase
{
    /** @test */
    public function user_can_add_user_to_chat()
    {
        $users = User::factory()->count(3)->create()->toArray();
        $chat = Chat::factory()->count(1)->create()->toArray();
        $chat_id=$chat[0]['id'];
        foreach ($users as $participant) {
            Participant::create([
                'chat_id' => $chat_id,
                'user_id' => $participant['id'],
                'uid' => env('UID'),
                'udid' => env('UDID'),
                'company_id' => env('COMPANY_ID'),
                'is_active' => 1,
            ]);
        }
        Participant::create([
            'chat_id' => $chat_id,
            'user_id' => env('CURRENT_USER_ID'),
            'uid' => env('UID'),
            'udid' => env('UDID'),
            'company_id' => env('COMPANY_ID'),
            'is_active' => 1,
        ]);
        Group::create([
            'chat_id' => $chat_id,
            'name' => 'test group name',
            'uid' => env('UID'),
            'udid' => env('UDID'),
            'company_id' => env('COMPANY_ID'),
            'is_active' => 1,
            'created_by' => env('CURRENT_USER_ID'),
        ]);
        $chatData=[
            'chatId' => $chat_id,
            'userId' => $users[2]['id']
        ];
        $response=$this->post("api/remove-user-from-chat", $chatData);
        return expect($response->getStatusCode())->toEqual(200);
    }
}
