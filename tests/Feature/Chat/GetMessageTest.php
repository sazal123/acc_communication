<?php

namespace Tests\Feature\Chat;

use App\Models\Chat\Chat;
use App\Models\Chat\Group;
use App\Models\Chat\Participant;
use App\Models\User;
use Tests\TestCase;

class GetMessageTest extends TestCase
{
    /** @test */
    public function user_can_get_message_by_chat_id()
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
        $this->post("api/send-message", $messageData);
        $response=$this->get("api/get-message?chatId=".$chat_id);
        return expect($response->getStatusCode())->toEqual(200);
    }
}
