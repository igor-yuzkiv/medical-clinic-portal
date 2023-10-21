<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RegisterUserRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'name'      => 'required|string|max:255',
            'login'     => 'required|string|unique:users|max:255',
            'password'  => 'required|string|max:255',
            'email'     => 'nullable|email|unique:users|max:255',
            'phone'     => 'nullable|string|unique:users|max:255',
            'role'      => 'required|nullable',
            'gender'    => 'nullable|string',
            'source_id' => 'nullable|unique:users|string',
        ];
    }

    public function authorize(): bool
    {
        return true;
    }
}
