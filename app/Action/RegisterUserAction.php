<?php

namespace App\Action;

use App\Abstractions\Action\ActionInterface;
use App\DTO\UserDto;
use App\Models\User;

/**
 *
 */
class RegisterUserAction implements ActionInterface
{
    /**
     * @param UserDto $userDto
     */
    public function __construct(
        private readonly UserDto $userDto
    )
    {

    }

    /**
     * @return User
     */
    public function handle(): User
    {
        $user = User::query()
            ->where('phone', $this->userDto->phone)
            ->first();

        if (!$user) {
            return User::create($this->userDto->toArray());
        }

        if ($user->is_active) {
            throw new \RuntimeException('User already exists');
        }

        $data = $this->userDto->toArray();
        $data["password"] = \Hash::make($this->userDto->password);
        $data['is_active'] = true;

        $user->update($data);
        return $user;
    }
}
