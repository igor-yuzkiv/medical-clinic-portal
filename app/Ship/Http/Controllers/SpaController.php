<?php

namespace App\Ship\Http\Controllers;

use App\Abstractions\Controller\Controller;

class SpaController extends Controller
{
    public function __invoke()
    {
        return view('spa');
    }
}
