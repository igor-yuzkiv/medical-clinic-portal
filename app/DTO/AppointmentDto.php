<?php

namespace App\DTO;

use App\Abstractions\DTO\DataTransferObject;

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
