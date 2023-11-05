<?php

namespace App\Containers\User\Http\Requests;

use App\Containers\User\DTO\UserDto;
use App\Utils\LoggerUtil;
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
            'phone'     => 'required|string|max:255',
            'login'     => 'nullable|string|unique:users|max:255',
            'email'     => 'nullable|email|unique:users|max:255',
            'password'  => 'required|string|max:255',
            'role'      => 'required|nullable',
            'gender'    => 'nullable|string',
            'source_id' => 'nullable|string',
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

        if (isset($data["phone"])) {
            $data["phone"] = preg_replace('/[^0-9]/', '', $data["phone"]);
        }

        if (!$this->input('login')) {
            $data["login"] = $this->input("phone");
        }

        return UserDto::of($data);
    }

    /**
     * @return void
     */
    public function prepareForValidation(): void
    {
        LoggerUtil::info("RegisterUserRequest", $this->all());
        //TODO: remove this
    }
}
