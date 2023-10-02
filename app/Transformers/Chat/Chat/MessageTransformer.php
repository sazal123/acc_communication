<?php

namespace App\Transformers\Chat\Chat;

use App\Models\Chat\Message;
use Flugg\Responder\Transformers\Transformer;

class MessageTransformer extends Transformer
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
     * @param  Message $message
     * @return array
     */
    public function transform($message)
    {
        return [
            'id' => $message->id,
            'content' => $message->content,
            'sender_id' => $message->user_id,
            'is_active' => $message->is_active,
            'created_at' => $message->created_at,
        ];
    }
}
