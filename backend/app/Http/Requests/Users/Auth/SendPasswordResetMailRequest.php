<?php

namespace App\Http\Requests\Users\Auth;

use App\Http\Requests\ApiRequest;

class SendPasswordResetMailRequest extends ApiRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'email' => ['required', 'email', 'max:255', 'exists:users,email']
        ];
    }
}
