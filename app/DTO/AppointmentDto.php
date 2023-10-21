<?php

namespace App\DTO;

use App\Abstractions\DTO\DataTransferObject;

class AppointmentDto extends DataTransferObject
{
    public int $doctor_id;
    public ?int $patient_id;

    public ?PatientDto $patient = null;
    public string $date_time;
    public string $service_name;
}
