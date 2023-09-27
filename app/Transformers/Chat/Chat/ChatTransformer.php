<?php

namespace App\Transformers\Chat\Chat;

use App\Models\Chat\Chat;
use Flugg\Responder\Transformers\Transformer;

class ChatTransformer extends Transformer
{
    /**
     * List of available relations.
     *
     * @var string[]
     */
    protected $relations = [];

    /**
     * List of autoloaded default relations.
     *
     * @var array
     */
    protected $load = [];

    /**
     * Transform the model.
     *
     * @param  \App\Models\Chat\Chat $chat
     * @return array
     */
    public function transform(Chat $chat)
    {
        return [
            'id' => (int) $chat->id,

        ];
    }
}
