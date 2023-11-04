<?php

namespace App\Containers\Patient\DTO;

use App\Abstractions\DTO\DataTransferObject;

/**
 *
 */
class PatientDto extends DataTransferObject
{
    /**
     * @var string
     */
    public string $name;
    /**
     * @var string
     */
    public string $phone;
}
