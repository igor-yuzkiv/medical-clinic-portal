<?php

namespace App\Containers\Appointment\Actions;

use App\Abstractions\Action\ActionInterface;
use App\Containers\Appointment\DTO\AppointmentDto;
use App\Containers\Appointment\Models\Appointment;
use App\Containers\Patient\Actions\CreatePatientAction;
use App\Containers\User\Models\User;

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
