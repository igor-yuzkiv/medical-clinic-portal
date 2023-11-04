<?php

namespace App\Containers\Appointment\Actions;

use App\Abstractions\Action\ActionInterface;
use App\Containers\Appointment\DTO\AppointmentDto;
use App\Containers\Appointment\Models\Appointment;
use App\Containers\Patient\Actions\CreatePatientAction;
use App\Containers\User\Enums\UserRoleEnum;
use App\Containers\User\Models\User;

/**
 *
 */
class SaveAppointmentAction implements ActionInterface
{
    /**
     * @param AppointmentDto $appointmentDto
     */
    public function __construct(
        private readonly AppointmentDto $appointmentDto,
        private readonly ?Appointment $appointment = null
    )
    {

    }

    /**
     * @return Appointment
     */
    public function handle(): Appointment
    {
        if ($this->appointmentDto->is_new_patient) {
            $this->appointmentDto->patient_id = $this->createNewPatient();
        }

        if ($this->appointment) {
            $this->appointment->update($this->appointmentDto->toArray());
            return $this->appointment;
        }

        return Appointment::create($this->appointmentDto->toArray());
    }

    /**
     * @return int
     */
    private function createNewPatient(): int
    {
        $doctor = User::where("role", UserRoleEnum::DOCTOR)
            ->where('id', $this->appointmentDto->doctor_id)
            ->firstOrFail();

        $patient = (new CreatePatientAction($this->appointmentDto->patient, $doctor))->handle();

        return $patient->id;
    }
}
