<?php

use App\Http\Controllers\web\AuthController;
use App\Http\Controllers\web\Sms_tokenController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('/mono', function () {
    return 'mono';
});


Route::post('/onboard', [AuthController::class, 'onboard']);
Route::post('/login', [AuthController::class, 'login']);
Route::get('/create', [AuthController::class, 'create']);
// Route::any('/onboard/{id}', [AuthController::class, 'personal']);


    Route::get('/logout', [AuthController::class, 'logout']);


Route::get('/sendotp', [Sms_tokenController::class, 'sendotp']);
Route::get('/sendsms', [Sms_tokenController::class, 'sendsms']);
Route::get('/verifyotp', [Sms_tokenController::class, 'verifyotp']);

Route::group(['middleware' => ['auth:sanctum']], function () {
    Route::get('/sms', [Sms_tokenController::class, 'sendsms']);
    Route::get('/sendotp', [Sms_tokenController::class, 'sendotp']);
    Route::get('/sendsms', [Sms_tokenController::class, 'sendsms']);
    Route::get('/verifyotp', [Sms_tokenController::class, 'verifyotp']);
    
    // Route::get('/logout/', [AuthController::class, 'logout']);
});