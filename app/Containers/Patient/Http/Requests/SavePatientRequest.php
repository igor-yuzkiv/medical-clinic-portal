<?php

namespace App\Containers\Patient\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SavePatientRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'name'    => ['required'],
            'phone'   => ['required'],
            'email'   => ['nullable', 'email', 'max:254'],
            'user_id' => ['nullable', 'integer'],
        ];
    }

    public function authorize(): bool
    {
        return true;
    }
}
