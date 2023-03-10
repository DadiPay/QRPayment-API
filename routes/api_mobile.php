<?php

use App\Http\Controllers\mobile\AuthController;
use App\Http\Controllers\mobile\ChangePasswordController;
use App\Http\Controllers\mobile\PaymentController;
use App\Http\Controllers\mobile\SmsController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
Route::post('/forgetpassword', [ChangePasswordController::class, 'forget']);

Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);
Route::put('/setpin', [AuthController::class, 'setpin']);

Route::get('/sms/{number}', [SmsController::class, 'sendsms']);
Route::get('/sendotpmobile/{number}', [SmsController::class, 'sendotpmobile']);
Route::get('/sendotpmail/{email}', [SmsController::class, 'sendotpmail']);
Route::get('/sendsms/{number}', [SmsController::class, 'sendsms']);
Route::get('/verifyotp/{pin}/{code}', [SmsController::class, 'verifyotp']);
Route::get('/sendwhatsapp/{number}', [SmsController::class, 'sendwhatsapp']);


Route::group(['middleware' => ['auth:sanctum']], function () {
    // Route::get('/sms', [SmsController::class, 'sendsms']);
    // Route::get('/sendotp', [SmsController::class, 'sendotp']);
    // Route::get('/sendsms', [SmsController::class, 'sendsms']);
    // Route::get('/verifyotp', [SmsController::class, 'verifyotp']);
    
    Route::get('/logout', [AuthController::class, 'logout']);
});


Route::group([
        'middleware' => "api",
        "prefix" => "payment",],
    function () {
    Route::get("generateQRCode", [PaymentController::class, "generateQRCode"]);
    Route::get("generateDetails/{code}", [PaymentController::class, "generatePaymentDetails"]);
});