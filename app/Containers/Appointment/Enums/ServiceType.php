<?php

namespace App\Containers\Appointment\Enums;

enum ServiceType : int
{
    case MRI = 1;

    case CT = 2;
    case X_RAY = 3;
}
