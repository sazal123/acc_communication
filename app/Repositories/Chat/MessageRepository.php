<?php

namespace App\Repositories\Chat;

use App\Contracts\Chat\MessageContract;
use App\DataSources\LocalSources\Chat\MessageSource;
use App\Transformers\Chat\Chat\MessageTransformer;
use Flugg\Responder\Responder;
use Illuminate\Support\Facades\DB;
use Exception;
use Illuminate\Support\Facades\Log;

class MessageRepository implements MessageContract {
    protected mixed $response;
    protected MessageSource $messageSource;

    public function __construct(MessageSource $messageSource){
        $this->messageSource=$messageSource;
    }

    public function sendMessage($payload){

        DB::beginTransaction();
        try {
            if(!empty($payload)) {
                $this->response = $this->messageSource->sendMessage($payload);
            }
            DB::commit();
        } catch (Exception $e) {
            DB::rollBack();
            Log::info($e->getMessage());
            throw new Exception($e->getMessage(), $e->getCode());
        }
        return responder()->success($this->response)->respond();
    }

    public function getMessage($payload){

        DB::beginTransaction();
        try {
            if(!empty($payload)) {
                $this->response = $this->messageSource->getMessage($payload);
            }
            DB::commit();
        } catch (Exception $e) {
            DB::rollBack();
            Log::info($e->getMessage());
            throw new Exception($e->getMessage(), $e->getCode());
        }
        return responder()->success($this->response, new MessageTransformer())->respond();
    }

}
