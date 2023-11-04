<?php

namespace App\Abstractions\Controller;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

abstract class ResourceController extends BaseController
{
    use AuthorizesRequests, ValidatesRequests;
}
