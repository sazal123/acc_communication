<?php

namespace App\Http\Requests\Chat\Chat;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class RemoveUserFromChatRequest extends FormRequest
{
    public function __construct()
    {
        parent::__construct();
        $this->accepts('application/json');
    }
    public function rules(): array
    {
        return [
            'userId' => 'required|integer|exists:users,id',
            'chatId' => 'required|integer|exists:acc_com_chats,id',
        ];
    }
    public function messages(): array
    {
        return [
            'userId.required' =>  'User Id  is required.',
            'chatId.required' =>  'Chat Id  is required.',
        ];
    }
    public function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(response()->json([
            'success'   => false,
            'message'      => $validator->errors()
        ]));
    }
}


