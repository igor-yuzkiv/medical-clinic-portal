<?php

use Illuminate\Support\Facades\Route;

Route::get('/{any?}', \App\Providers\Ship\Http\Controllers\SpaController::class)->where('any', '^((?!api|sanctum).)*$');
