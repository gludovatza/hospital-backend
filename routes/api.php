<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\ReservationController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::apiResource('reservation', \App\Http\Controllers\ReservationController::class);
    Route::apiResource('service', \App\Http\Controllers\ServiceController::class);
    Route::apiResource('appointment', \App\Http\Controllers\AppointmentController::class);
    Route::apiResource('employee', \App\Http\Controllers\EmployeeController::class);
});

Route::get('/getAllReservations', [ReservationController::class, 'getAll']);
Route::post('/signup', [AuthController::class, 'signup']);
Route::post('/login', [AuthController::class, 'login']);

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
