<?php

namespace App\DTO;

use App\Abstractions\DTO\DataTransferObject;

class PatientDto extends DataTransferObject
{
    public string $name;
    public string $phone;
}
