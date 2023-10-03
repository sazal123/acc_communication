<?php

namespace App\DataSources\LocalSources\Chat;

use App\Models\Chat\Chat;
use App\Models\Chat\Group;
use App\Models\Chat\Participant;
use Exception;
use Illuminate\Support\Facades\Auth;

class  ChatSource
{
    protected readonly Chat $chat;
    protected  array $result;

    public function __construct(Chat $chat)
    {
        $this->chat = $chat;
    }

    public function createChat($payload){
        try{

            if(isset($payload['participantId']) ) {
                if($this->ifChatExist($payload['participantId'])){
                    $this->result['added']=false;
                }
                else{
                    $this->chat->uid=env('UID');
                    $this->chat->udid=env('UDID');
                    $this->chat->company_id=env('COMPANY_ID');
                    $this->chat->is_active=true;
                    $this->chat->save();
                    $this->chat->users()->syncWithPivotValues([env('CURRENT_USER_ID'),$payload['participantId']],['uid' => env('UID'),'udid' => env('UDID'),'company_id' => env('COMPANY_ID'),'is_active'=>true]);
                    $this->result['added']=true;
                }
                return $this->result;


            }else{
                throw new Exception('Write Exception has occurred.', 409);
            }
        }catch(Exception $e){
            throw new Exception($e->getMessage(), $e->getCode());
        }
    }

    public function ifChatExist($participantId){
        $user1Chats = Participant::where('user_id', env('CURRENT_USER_ID'))->pluck('chat_id')->all();
        $commonChat = Participant::where('user_id', $participantId)
            ->whereIn('chat_id', $user1Chats)
            ->first();

        return $commonChat;
    }

    public function createGroupChat($payload){
        try{

            if(isset($payload['participantIds']) && is_array($payload['participantIds']) ) {
                $this->chat->uid=env('UID');
                $this->chat->udid=env('UDID');
                $this->chat->company_id=env('COMPANY_ID');
                $this->chat->is_group=true;
                $this->chat->is_active=true;
                $this->chat->save();
                $participants=$payload['participantIds'];
                array_push($participants,env('CURRENT_USER_ID'));
                $this->chat->users()->syncWithPivotValues($participants,['uid' => env('UID'),'udid' => env('UDID'),'company_id' => env('COMPANY_ID'),'is_active'=>true]);
                $groupDetail = new Group();
                $groupDetail->uid=env('UID');
                $groupDetail->udid=env('UDID');
                $groupDetail->company_id=env('COMPANY_ID');
                $groupDetail->chat_id = $this->chat->id;
                $groupDetail->is_active = true;
                $groupDetail->name = $payload['group_name'];
                $groupDetail->created_by = env('CURRENT_USER_ID'); // Assuming user authentication is in place
                $groupDetail->save();
                $this->result['added']=true;

                return $this->result;


            }else{
                throw new Exception('Write Exception has occurred.', 409);
            }
        }catch(Exception $e){
            throw new Exception($e->getMessage(), $e->getCode());
        }
    }

    public function deleteChat($payload){
        try{

            if(isset($payload['chatId']) ) {
                $chat = $this->chat::find($payload['chatId']);
                if($chat){
                    $chat->users()->updateExistingPivot(env('CURRENT_USER_ID'), ['is_active' => false]);
                    $this->result['message']='chat deleted';
                }
                else{
                    $this->result['message']='chat id not found';
                }
                return $this->result;


            }else{
                throw new Exception('Write Exception has occurred.', 409);
            }
        }catch(Exception $e){
            throw new Exception($e->getMessage(), $e->getCode());
        }
    }

    public function deleteGroupChat($payload){
        try{

            if(isset($payload['chatId']) ) {
                $chat = $this->chat::with('group')->find($payload['chatId']);
                if($chat){
                    if($chat->group->created_by==env('CURRENT_USER_ID')){
                        $chat = $this->chat::find($payload['chatId']);
                        $chat->delete();
                        $this->result['message']='chat deleted';
                    }
                    else{
                        $this->result['message']='permission error';
                    }
                }
                else{
                    $this->result['message']='chat id not found';
                }
                return $this->result;


            }else{
                throw new Exception('Write Exception has occurred.', 409);
            }
        }catch(Exception $e){
            throw new Exception($e->getMessage(), $e->getCode());
        }
    }

    public function getChat(){
        try{
            $userId=env('CURRENT_USER_ID');

                $this->result = Chat::whereHas('users', function ($query) use ($userId) {
                    $query->where('user_id', $userId)
                        ->where('is_active', true);
                })
                ->with('group')
                ->get()
                ->toArray();
                return $this->result;


        }catch(Exception $e){
            throw new Exception($e->getMessage(), $e->getCode());
        }
    }

    public function adduserToChatChat($payload){
        try{
            if(isset($payload['chatId']) && isset($payload['userId']) ) {
                $isGroup = $this->checkIsGroup($payload['chatId']);
                if($isGroup){
                    $permission=$this->checkPermissionForAddUserToChat($payload['chatId']);
                    if($permission){
                        $isUserExistInChat=$this->checkIsUserExistInChat($payload['chatId'],$payload['userId']);
                        if($isUserExistInChat){
                            $this->chat->users()->attach($payload['userId'],['chat_id'=>$payload['chatId'],'uid' => env('UID'),'udid' => env('UDID'),'company_id' => env('COMPANY_ID'),'is_active'=>true]);
                            $this->result['message']='User added in chat';
                        }
                        else{
                            $this->result['message']='User already in chat';
                        }
                    }
                    else{
                        $this->result['message']='Permission error';
                    }
                }
                else{
                    $this->result['message']='Not a group';
                }
                return $this->result;

            }else{
                throw new Exception('Write Exception has occurred.', 409);
            }
        }catch(Exception $e){
            throw new Exception($e->getMessage(), $e->getCode());
        }
    }

    public function checkIsGroup($chatId){
        $chat=$this->chat::find($chatId);
        if($chat){
            if($chat->is_group==true){
                return true;
            }
            else{
                return false;
            }
        }
        else{
            return false;
        }
    }

    public function checkIsUserExistInChat($chatId,$userId){
        $chatdata=$this->chat::find($chatId);
        if($chatdata){
            $chat=$this->chat->with('users')->find($chatId);
            if ($chat->users->contains($userId)) {
                return false;
            }
            else{
                return true;
            }
        }
        else{
            return false;
        }

    }
    public function checkPermissionForAddUserToChat($chatId){
        $chatdata=$this->chat::find($chatId);
        if($chatdata){
            $chat = $this->chat::with('group')->find($chatId);
            if($chat->group->created_by==env('CURRENT_USER_ID')){
                return true;
            }
            else{
                return false;
            }
        }
        else{
            return false;
        }

    }
}
