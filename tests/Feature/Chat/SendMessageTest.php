<?php

namespace Tests\Feature\Chat;

use App\Models\Chat\Chat;
use App\Models\Chat\Group;
use App\Models\Chat\Participant;
use App\Models\User;
use Tests\TestCase;

class SendMessageTest extends TestCase
{
    /** @test */
    public function user_can_send_message_over_chat()
    {
        $users = User::factory()->count(2)->create()->toArray();
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
        $messageData=[
            'chatId' => $chat_id,
            'content' => 'test message'
        ];
        $response=$this->post("api/send-message", $messageData);
        return expect($response->getStatusCode())->toEqual(200);
    }
}
