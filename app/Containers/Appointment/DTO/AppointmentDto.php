<?php

namespace App\Containers\Appointment\DTO;

use App\Abstractions\DTO\DataTransferObject;
use App\Containers\Patient\DTO\PatientDto;

/**
 *
 */
class AppointmentDto extends DataTransferObject
{
    /**
     * @var int
     */
    public int $doctor_id;

    /**
     * @var int|null
     */
    public ?int $patient_id;

    /**
     * @var PatientDto|null
     */
    public ?PatientDto $patient = null;

    /**
     * @var string
     */
    public string $date_time;

    /**
     * @var string
     */
    public string $service_name;
}
