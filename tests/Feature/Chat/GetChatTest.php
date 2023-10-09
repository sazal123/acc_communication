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
        $users = User::factory()->count(10)->create();
        $usersIDs = User::pluck('id')->toArray();
        $random_id = array_rand($usersIDs);
        $chatData = [
            'participantId' => $usersIDs[$random_id]
        ];
        $this->post("api/create-chat", $chatData);
        $groupChatIds=array_slice($usersIDs,0,5);
        $groupChatData=[
            'participantIds' => $groupChatIds,
            'group_name' => 'testing group'
        ];
        $this->post("api/create-group-chat", $groupChatData);
        $response = $this->get("/api/get-chat");
        return expect($response->getStatusCode())->toEqual(200);
    }
}
