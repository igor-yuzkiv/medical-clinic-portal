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
        Route::middleware('auth:sanctum')->get("user", [\App\Http\Controllers\AuthController::class, "getCurrentUser"]);
        Route::post("login", [\App\Http\Controllers\AuthController::class, "login"]);
        Route::post("logout", [\App\Http\Controllers\AuthController::class, "logout"]);
        Route::post("register", [\App\Http\Controllers\AuthController::class, "register"]);
    });


Route::resource("appointments", \App\Http\Controllers\AppointmentController::class)
    ->except(["create", "edit"])
    ->middleware('auth:sanctum');

Route::prefix("users")
    ->middleware('auth:sanctum')
    ->group(function () {
        Route::get("", [\App\Http\Controllers\UserController::class, "index"]);
    });
