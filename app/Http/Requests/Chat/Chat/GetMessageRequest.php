<?php

namespace App\Http\Requests\Chat\Chat;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class GetMessageRequest extends FormRequest
{
    public function __construct()
    {
        parent::__construct();
        $this->accepts('application/json');
    }
    public function rules(): array
    {
        return [
            'chatId' => 'required|integer',
        ];
    }
    public function messages(): array
    {
        return [
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


