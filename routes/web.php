<?php

use Illuminate\Support\Facades\Route;

Route::get('/{any?}', \App\Http\Controllers\SpaController::class)->where('any', '^((?!api|sanctum).)*$');
