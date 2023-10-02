<?php

namespace App\Events;

use App\Models\User;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class ChatEvent implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;
    public int $sender_id;
    public mixed $message;
    public array $participantIds;
    public int $chat_id;

    /**
     * Create a new event instance.
     */
    public function __construct($sender_id,$message,$participantIds,$chat_id)
    {
        $this->sender_id=$sender_id;
        $this->message=$message;
        $this->participantIds=$participantIds;
        $this->chat_id=$chat_id;
        $this->dontBroadcastToCurrentUser();
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return array<int, \Illuminate\Broadcasting\Channel>
     */
    public function broadcastOn(): array
    {
        return [
            new PrivateChannel('chat'.$this->chat_id)
        ];
    }
}
