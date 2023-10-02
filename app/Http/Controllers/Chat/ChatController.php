<?php

namespace App\Http\Controllers\Chat;
use App\Events\ChatEvent;
use App\Http\Controllers\Controller;
use App\Http\Requests\Chat\Chat\CreateChatRequest;
use App\Http\Requests\Chat\Chat\CreateGroupChatRequest;
use App\Http\Requests\Chat\Chat\DeleteChatRequest;
use App\Models\User;
use App\Repositories\Chat\ChatRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\RateLimiter;
use Exception;

class ChatController extends Controller
{
    protected readonly ChatRepository $chatRepository;
    protected array $communication = ['service' => 'communication'];
    protected array $payload = [];
    protected array $result = [];

    public function __construct(ChatRepository $chatRepository){
        $this->chatRepository=$chatRepository;
    }

//    public function send(){
//        $user= User::find(Auth::id());
//        $message='ok';
//        event(new ChatEvent($message,$user));
//    }
    public function createChat(CreateChatRequest $request){
        try {
            $this->communication['slug'] = 'create-chat';
            $this->communication['ip'] = $request->getClientIp();
            $this->payload = $this->trimAndStrip($request->all());
            $executed = RateLimiter::attempt(
                $this->communication['slug'] . ':' . $this->communication['ip'],
                $perMinute = env('API_REQUESTS_PER_MINUTE'),
                function () {
                    $this->result['status'] = 200;
                    $this->result['data'] = $this->chatRepository->createChat($this->payload);
                });
            if (!$executed) {
                throw new Exception('Too many requests..', 429);
            }
        } catch (Exception $e) {
            $this->result['status'] = $e->getCode();
            $this->result['message'] = $e->getMessage();
        }
        return response()->json($this->result, $this->result['status']);

    }

    public function createGroupChat(CreateGroupChatRequest $request){
        try {
            $this->communication['slug'] = 'create-group-chat';
            $this->communication['ip'] = $request->getClientIp();
            $this->payload = $this->trimAndStrip($request->all());
            $executed = RateLimiter::attempt(
                $this->communication['slug'] . ':' . $this->communication['ip'],
                $perMinute = env('API_REQUESTS_PER_MINUTE'),
                function () {
                    $this->result['status'] = 200;
                    $this->result['data'] = $this->chatRepository->createGroupChat($this->payload);
                });
            if (!$executed) {
                throw new Exception('Too many requests..', 429);
            }
        } catch (Exception $e) {
            $this->result['status'] = $e->getCode();
            $this->result['message'] = $e->getMessage();
        }
        return response()->json($this->result, $this->result['status']);

    }

    public function deleteChat(DeleteChatRequest $request){
        try {
            $this->communication['slug'] = 'delete-chat';
            $this->communication['ip'] = $request->getClientIp();
            $this->payload = $this->trimAndStrip($request->all());
            $executed = RateLimiter::attempt(
                $this->communication['slug'] . ':' . $this->communication['ip'],
                $perMinute = env('API_REQUESTS_PER_MINUTE'),
                function () {
                    $this->result['status'] = 200;
                    $this->result['data'] = $this->chatRepository->deleteChat($this->payload);
                });
            if (!$executed) {
                throw new Exception('Too many requests..', 429);
            }
        } catch (Exception $e) {
            $this->result['status'] = $e->getCode();
            $this->result['message'] = $e->getMessage();
        }
        return response()->json($this->result, $this->result['status']);

    }
}
