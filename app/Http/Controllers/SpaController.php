<?php

namespace App\Http\Controllers;

use App\Abstractions\Controller\Controller;

class SpaController extends Controller
{
    public function __invoke()
    {
        return view('spa');
    }
}
