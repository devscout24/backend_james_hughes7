<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\ReviewController;



Route::controller(AuthController::class)->group(function () {
    // user login and logout
    Route::post('/user-login', 'login');
    Route::post('/user-signup', 'signup');
    Route::post('/user-logout', 'logout');
    // user otp verify
    Route::post('/send-otp', 'sendOtp');
    Route::post('/verify-otp', 'checkOtp');
    Route::post('/password/create', 'PasswordCreate');
    Route::post('reset-password', [AuthController::class, 'resetPassword']);
    Route::post('verify/email_otp', [AuthController::class, 'verifyEmailOtp']);
    // user profile
    Route::post('/update-user', [AuthController::class, 'updateUser']);
    Route::post('/delete-account', [AuthController::class, 'deleteSelfAccount'])->middleware('auth:api');
    Route::post('/user/profile/reset-password', [AuthController::class, 'userResetPassword'])->middleware('auth:api');

    Route::post('forget/password', 'forgetPassword');
    Route::post('otp/check', 'checkOtp');
    Route::post('reset/password', 'resetPassword');
    Route::post('/resend/otp', 'resendOtp');

});



Route::middleware('auth:api')->group(function () {


Route::controller(AuthController::class)->group(function () {
    Route::post('/user/profile/set', 'userProfileSet');
    Route::post('/profile/image/update','ProfileImageUpdate');

});


});
require __DIR__ . '/shahin.php';
