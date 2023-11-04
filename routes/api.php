<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});


Route::prefix("auth")
    ->group(function () {
        Route::middleware('auth:sanctum')->get("user", [\App\Containers\User\Http\Controllers\AuthController::class, "getCurrentUser"]);
        Route::post("login", [\App\Containers\User\Http\Controllers\AuthController::class, "login"]);
        Route::post("logout", [\App\Containers\User\Http\Controllers\AuthController::class, "logout"]);
        Route::post("register", [\App\Containers\User\Http\Controllers\AuthController::class, "register"]);
    });

Route::prefix("users")
    ->middleware('auth:sanctum')
    ->group(function () {
        Route::get("", [\App\Containers\User\Http\Controllers\UserController::class, "index"]);
    });

Route::prefix("patients")
    ->middleware('auth:sanctum')
    ->group(function () {
        Route::get("", [\App\Containers\Patient\Http\Controllers\PatientController::class, "index"]);
    });


Route::prefix("appointments")
    ->middleware('auth:sanctum')
    ->group(function () {
        Route::get("", [\App\Containers\Appointment\Http\Controllers\AppointmentController::class, "index"]);
        Route::post("", [\App\Containers\Appointment\Http\Controllers\AppointmentController::class, "store"]);
        Route::get("{appointment}", [\App\Containers\Appointment\Http\Controllers\AppointmentController::class, "show"])->where("appointment", "[0-9]+");
        Route::put("{appointment}", [\App\Containers\Appointment\Http\Controllers\AppointmentController::class, "update"])->where("appointment", "[0-9]+");
        Route::delete("{appointment}", [\App\Containers\Appointment\Http\Controllers\AppointmentController::class, "destroy"])->where("appointment", "[0-9]+");
    });
