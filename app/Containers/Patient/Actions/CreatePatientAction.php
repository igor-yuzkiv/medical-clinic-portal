<?php

namespace App\Containers\Patient\Actions;

use App\Abstractions\Action\ActionInterface;
use App\Containers\Doctor\Models\DoctorPatient;
use App\Containers\Patient\DTO\PatientDto;
use App\Containers\Patient\Models\Patient;
use App\Containers\User\Enums\UserRoleEnum;
use App\Containers\User\Models\User;

/**
 *
 */
class CreatePatientAction implements ActionInterface
{
    /**
     * @param PatientDto $patientDto
     * @param User $doctor
     */
    public function __construct(
        private readonly PatientDto $patientDto,
        private User                $doctor
    )
    {
        if ($this->doctor->role !== UserRoleEnum::DOCTOR) {
            throw new \DomainException("Only doctors can create patients");
        }
    }

    /**
     * @return Patient
     */
    public function handle(): Patient
    {
        $this->patientDto->phone = preg_replace('/[^0-9]/', '', $this->patientDto->phone);
        $patient = Patient::where("phone", $this->patientDto->phone)->first();

        if ($patient) {
            $relationExists = DoctorPatient::where("doctor_id", $this->doctor->id)
                ->where("patient_id", $patient->id)
                ->exists();

            if (!$relationExists) {
                $this->createRelation($patient->id);
            }

            return $patient;
        }

        $patient = Patient::create($this->patientDto->toArray());
        $this->createRelation($patient->id);

        return $patient;
    }

    /**
     * @param int $patient_id
     * @return void
     */
    private function createRelation(int $patient_id): void
    {
        DoctorPatient::create([
            "doctor_id"  => $this->doctor->id,
            "patient_id" => $patient_id,
        ]);
    }
}
