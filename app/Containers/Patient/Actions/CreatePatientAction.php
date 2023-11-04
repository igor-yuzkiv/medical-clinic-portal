<?php

namespace App\Containers\Patient\Actions;

use App\Abstractions\Action\ActionInterface;
use App\Containers\Patient\DTO\PatientDto;
use App\Containers\User\Enums\UserRoleEnum;
use App\Containers\User\Models\User;

/**
 *
 */
class CreatePatientAction implements ActionInterface
{
    /**
     * @param PatientDto $patientDto
     */
    public function __construct(
        private readonly PatientDto $patientDto
    )
    {

    }

    /**
     * @return User
     */
    public function handle(): User
    {
        return User::create([
            'name'      => $this->patientDto->name,
            'phone'     => $this->patientDto->phone,
            'password'  => \Hash::make(\Str::random(16)),
            'role'      => UserRoleEnum::PATIENT,
            'login'     => $this->patientDto->phone,
            'is_active' => false,
        ]);
    }
}
