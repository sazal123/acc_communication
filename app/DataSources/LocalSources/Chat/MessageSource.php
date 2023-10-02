<?php

namespace App\DataSources\LocalSources\Chat;

use App\Events\ChatEvent;
use App\Models\Chat\Chat;
use App\Models\Chat\Message;
use App\Models\User;
use Exception;
use Illuminate\Support\Facades\DB;


class  MessageSource
{
    protected readonly Message $message;
    protected  array $result;

    public function __construct(Message $message)
    {
        $this->message = $message;
    }

    public function sendMessage($payload){
        try{

            if(isset($payload['chatId']) && isset($payload['content'] ) ) {

                $this->message->uid=env('UID');
                $this->message->udid=env('UDID');
                $this->message->company_id=env('COMPANY_ID');
                $chat=Chat::find($payload['chatId']);
                if($chat){
                    $user=User::find(env('CURRENT_USER_ID'));
                    $this->message->content=$payload['content'];
                    $this->message->user()->associate($user);
                    $chat->messages()->save($this->message);
                    $chat->users()->updateExistingPivot(env('CURRENT_USER_ID'), ['is_active' => true]);
                    $this->broadcastMessage(env('CURRENT_USER_ID'),$payload['chatId'],$payload['content']);
                    $this->result['message']='message sent';
                }
                else{
                    $this->result['message']='Chat id not found';
                }


                return $this->result;


            }else{
                throw new Exception('Write Exception has occurred.', 409);
            }
        }catch(Exception $e){
            throw new Exception($e->getMessage(), $e->getCode());
        }
    }

    public function getMessage($payload){
        try{

            if(isset($payload['chatId']) ) {
                $this->result = DB::table('acc_com_messages')
                    ->where('chat_id', $payload['chatId'])
                    ->get()
                    ->toArray();
                return $this->result;


            }else{
                throw new Exception('Read Exception has occurred.', 423);
            }
        }catch(Exception $e){
            throw new Exception($e->getMessage(), $e->getCode());
        }
    }

    public function broadcastMessage($sender_id,$chat_id,$message){
        $participantIds = DB::table('acc_com_participants')
            ->where('chat_id', $chat_id)
            ->where('user_id', '!=', $sender_id)
            ->pluck('user_id')
            ->toArray();
        event(new ChatEvent($sender_id,$message,$participantIds,$chat_id));
    }

}
