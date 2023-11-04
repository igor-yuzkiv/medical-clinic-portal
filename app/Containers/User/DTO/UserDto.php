<?php

namespace App\Containers\User\DTO;

use App\Abstractions\DTO\DataTransferObject;
use App\Containers\User\Enums\GenderEnum;
use App\Containers\User\Enums\UserRoleEnum;

/**
 *
 */
class UserDto extends DataTransferObject
{
    /**
     * @var string
     */
    public string $name;

    /**
     * @var string
     */
    public string $login;

    /**
     * @var string
     */
    public string $phone;

    /**
     * @var string
     */
    public string $password;

    /**
     * @var string|null
     */
    public ?string $email = null;

    /**
     * @var UserRoleEnum|int|null
     */
    public null|UserRoleEnum|int $role = null;

    /**
     * @var string|GenderEnum|null
     */
    public null|string|GenderEnum $gender = GenderEnum::UNKNOWN;

    /**
     * @var string|null
     */
    public ?string $source_id = null;
}