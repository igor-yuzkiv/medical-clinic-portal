<?php

namespace App\Http\Requests;

use App\DTO\UserDto;
use App\Utils\ResponseUtil;
use Illuminate\Foundation\Http\FormRequest;

/**
 *
 */
class RegisterUserRequest extends FormRequest
{
    /**
     * @return string[]
     */
    public function rules(): array
    {
        return [
            'name'      => 'required|string|max:255',
            'login'     => 'nullable|string|unique:users|max:255|required_without:phone',
            'password'  => 'required|string|max:255',
            'email'     => 'nullable|email|unique:users|max:255',
            'phone'     => 'nullable|string|unique:users|max:255|required_without:login',
            'role'      => 'required|nullable',
            'gender'    => 'nullable|string',
            'source_id' => 'nullable|unique:users|string',
        ];
    }

    /**
     * @return bool
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * @return UserDto
     */
    public function getUserDto(): UserDto
    {
        $data = $this->validated();
        if (!$this->input('login')) {
            $data["login"] = $this->input("phone");;
        }
        return UserDto::of($data);
    }
}
