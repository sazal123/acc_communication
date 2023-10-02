<?php

namespace App\Repositories\Chat;

use App\Contracts\Chat\ChatContract;
use App\DataSources\LocalSources\Chat\ChatSource;
use App\Transformers\Chat\Chat\ChatTransformer;
use Flugg\Responder\Responder;
use Illuminate\Support\Facades\DB;
use Exception;
use Illuminate\Support\Facades\Log;

class ChatRepository implements ChatContract{
    protected mixed $response;
    protected ChatSource $chatSource;

    public function __construct(ChatSource $chatSource){
        $this->chatSource=$chatSource;
    }

    public function createChat($payload){

        DB::beginTransaction();
        try {
            if(!empty($payload)) {
                $this->response = $this->chatSource->createChat($payload);
            }
            DB::commit();
        } catch (Exception $e) {
            DB::rollBack();
            Log::info($e->getMessage());
            throw new Exception($e->getMessage(), $e->getCode());
        }
        return responder()->success($this->response)->respond();
    }

    public function createGroupChat($payload){

        DB::beginTransaction();
        try {
            if(!empty($payload)) {
                $this->response = $this->chatSource->createGroupChat($payload);
            }
            DB::commit();
        } catch (Exception $e) {
            DB::rollBack();
            Log::info($e->getMessage());
            throw new Exception($e->getMessage(), $e->getCode());
        }
        return responder()->success($this->response)->respond();
    }

    public function deleteChat($payload){

        DB::beginTransaction();
        try {
            if(!empty($payload)) {
                $this->response = $this->chatSource->deleteChat($payload);
            }
            DB::commit();
        } catch (Exception $e) {
            DB::rollBack();
            Log::info($e->getMessage());
            throw new Exception($e->getMessage(), $e->getCode());
        }
        return responder()->success($this->response)->respond();
    }

    public function deleteGroupChat($payload){

        DB::beginTransaction();
        try {
            if(!empty($payload)) {
                $this->response = $this->chatSource->deleteGroupChat($payload);
            }
            DB::commit();
        } catch (Exception $e) {
            DB::rollBack();
            Log::info($e->getMessage());
            throw new Exception($e->getMessage(), $e->getCode());
        }
        return responder()->success($this->response)->respond();
    }
}
