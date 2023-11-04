<?php

namespace App\Containers\Patient\DTO;

use App\Abstractions\DTO\DataTransferObject;
use App\Containers\User\Enums\GenderEnum;

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

    /**
     * @var string|null
     */
    public ?string $email = null;

    /**
     * @var string|null|GenderEnum
     */
    public null|string|GenderEnum $gender = GenderEnum::UNKNOWN;

    /**
     * @var string|null
     */
    public ?string $source_id = null;
}
