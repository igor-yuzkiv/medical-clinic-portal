<?php

namespace App\DTO;

use App\Abstractions\DTO\DataTransferObject;
use App\Enums\GenderEnum;
use App\Enums\UserRoleEnum;

class UserDto extends DataTransferObject
{
    public string $name;
    public string $login;
    public string $phone;
    public string $password;
    public ?string $email = null;
    public null|UserRoleEnum|int $role = null;
    public null|string|GenderEnum $gender = GenderEnum::UNKNOWN;
    public ?string $source_id = null;
}
