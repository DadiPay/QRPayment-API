<?php

use App\Http\Controllers\mobile\AuthController;
<<<<<<< HEAD
use App\Http\Controllers\web\SmsController;
=======
use App\Http\Controllers\mobile\Sms_tokenController;
use App\Http\Controllers\mobile\PaymentController;
>>>>>>> 2973e96f088525f268a29a478ca87d4c8692280f
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


Route::group([
        'middleware' => "api",
        "prefix" => "payment",],
    function () {
    Route::get("generateQRCode", [PaymentController::class, "generateQRCode"]);
    Route::get("generateDetails/{code}", [PaymentController::class, "generatePaymentDetails"]);
});