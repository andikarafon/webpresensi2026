<?php

namespace App\Http\Requests\Api;

use Illuminate\Foundation\Http\FormRequest;

class LoginRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            /*
            @example admin@gls.com
            */
            'email' => 'required|email',

            /*
            @example edppdew
            */
            'password' => 'required|string',
        ];
    }

    public function messages(): array
    {
        return [
            'email.required' => 'Email is Required.',
            'email.email' => 'Please provide a valid email address',
            'password.required' => 'Password is Required.',
        ];
    }
}
