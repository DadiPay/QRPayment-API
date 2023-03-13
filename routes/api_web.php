<?php

use App\Http\Controllers\web\AuthController;
use App\Http\Controllers\web\Sms_tokenController;
use App\Http\Controllers\web\PaymentController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});


Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

Route::group(['middleware' => ['auth:sanctum']], function () {
    Route::get('/sms', [Sms_tokenController::class, 'sendsms']);
    Route::get('/sendotp', [Sms_tokenController::class, 'sendotp']);
    Route::get('/sendsms', [Sms_tokenController::class, 'sendsms']);
    Route::get('/verifyotp', [Sms_tokenController::class, 'verifyotp']);
    
    Route::get('/logout', [AuthController::class, 'logout']);
});

Route::group([
    'middleware' => "api",
    "prefix" => "payment",],
function () {
Route::get("generateQRCode", [PaymentController::class, "generateQRCode"]);
});