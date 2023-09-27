<?php

namespace App\Http\Requests\Chat\Chat;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class CreateGroupChatRequest extends FormRequest
{
    public function __construct()
    {
        parent::__construct();
        $this->accepts('application/json');
    }
    public function rules(): array
    {
        return [
            'participantIds'   => 'required|array|min:2',
            'participantIds.*' => 'exists:users,id',
            'group_name'       =>'required|string|max:100',
        ];
    }
    public function messages(): array
    {
        return [
            'participantIds.required' =>  'Participant Ids  is required.',
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


