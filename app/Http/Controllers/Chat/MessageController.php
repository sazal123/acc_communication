<?php

namespace App\Http\Controllers\Chat;
use App\Http\Controllers\Controller;
use App\Http\Requests\Chat\Message\GetMessageRequest;
use App\Http\Requests\Chat\Message\SendMessageRequest;
use App\Repositories\Chat\MessageRepository;
use Illuminate\Support\Facades\RateLimiter;
use Exception;

class MessageController extends Controller
{
    protected readonly MessageRepository $messageRepository;
    protected array $communication = ['service' => 'communication'];
    protected array $payload = [];
    protected array $result = [];

    public function __construct(MessageRepository $messageRepository){
        $this->messageRepository=$messageRepository;
    }
    public function sendMessage(SendMessageRequest $request){
        try {
            $this->communication['slug'] = 'send-message';
            $this->communication['ip'] = $request->getClientIp();
            $this->payload = $this->trimAndStrip($request->all());
            $executed = RateLimiter::attempt(
                $this->communication['slug'] . ':' . $this->communication['ip'],
                $perMinute = env('API_REQUESTS_PER_MINUTE'),
                function () {
                    $this->result['status'] = 200;
                    $this->result['data'] = $this->messageRepository->sendMessage($this->payload);
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

    public function getMessage(GetMessageRequest $request){
        try {
            $this->communication['slug'] = 'get-message';
            $this->communication['ip'] = $request->getClientIp();
            $this->payload = $this->trimAndStrip($request->all());
            $executed = RateLimiter::attempt(
                $this->communication['slug'] . ':' . $this->communication['ip'],
                $perMinute = env('API_REQUESTS_PER_MINUTE'),
                function () {
                    $this->result['status'] = 200;
                    $this->result['data'] = $this->messageRepository->getMessage($this->payload);
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
