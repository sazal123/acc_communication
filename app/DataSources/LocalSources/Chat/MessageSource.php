<?php

namespace App\DataSources\LocalSources\Chat;

use App\Models\Chat\Chat;
use App\Models\Chat\Message;
use App\Models\User;
use Exception;


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
                $user=User::find(env('CURRENT_USER_ID'));
                $this->message->content=$payload['content'];
                $this->message->user()->associate($user);
                $chat->messages()->save($this->message);
                $this->result['added']=true;

                return $this->result;


            }else{
                throw new Exception('Write Exception has occurred.', 409);
            }
        }catch(Exception $e){
            throw new Exception($e->getMessage(), $e->getCode());
        }
    }

}
