<?php

use App\Http\Controllers\mobile\AuthController;
use App\Http\Controllers\web\SmsController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('/mono', function () {
    return 'mono';
});

Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);
Route::put('/setpin', [AuthController::class, 'setpin']);


Route::group(['middleware' => ['auth:sanctum']], function () {
    Route::get('/sms', [SmsController::class, 'sendsms']);
    Route::get('/sendotp', [SmsController::class, 'sendotp']);
    Route::get('/sendsms', [SmsController::class, 'sendsms']);
    Route::get('/verifyotp', [SmsController::class, 'verifyotp']);
    
    Route::get('/logout', [AuthController::class, 'logout']);
});