<?php

namespace App\Action;

use App\Abstractions\Action\ActionInterface;
use App\DTO\UserDto;
use App\Enums\UserRoleEnum;
use App\Models\Patient;
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
        $user = User::create($this->userDto->toArray());
        if ($user->role === UserRoleEnum::PATIENT) {
            $this->updateRelatedPatient($user);
        }
        return $user;
    }

    /**
     * @param User $user
     * @return void
     */
    private function updateRelatedPatient(User $user): void
    {
        $patient = Patient::where("phone", $this->userDto->phone)->first();
        if ($patient) {
            $patient->user_id = $user->id;
            $patient->save();
        }
    }

}
