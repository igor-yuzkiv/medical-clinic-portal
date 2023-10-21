<?php

namespace App\DTO;

use App\Abstractions\DTO\DataTransferObject;
use App\Enums\GenderEnum;
use App\Enums\UserRoleEnum;

class UserDto extends DataTransferObject
{
    public string $name;
    public ?string $login = null;
    public string $password;
    public ?string $email = null;
    public ?string $phone;
    public null|UserRoleEnum|int $role = null;
    public null|string|GenderEnum $gender = null;
    public ?string $source_id = null;
}
