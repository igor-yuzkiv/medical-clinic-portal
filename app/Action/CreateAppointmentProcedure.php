<?php

namespace App\Action;

use App\Abstractions\Action\ActionInterface;
use App\DTO\AppointmentDto;
use App\Enums\UserRoleEnum;
use App\Models\Appointment;
use App\Models\User;

/**
 *
 */
class CreateAppointmentProcedure implements ActionInterface
{
    /**
     * @param AppointmentDto $appointmentDto
     */
    public function __construct(
        private readonly AppointmentDto $appointmentDto
    )
    {

    }

    /**
     * @return Appointment
     */
    public function handle(): Appointment
    {
        if (!isset($this->appointmentDto->patient_id)) {
            $this->appointmentDto->patient_id = $this->createPatient()->id;
        }
        return Appointment::create($this->appointmentDto->toArray());
    }

    /**
     * @return User
     */
    private function createPatient(): User
    {
        return (new CreatePatientAction($this->appointmentDto->patient))->handle();
    }
}
