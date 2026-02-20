<?php

use App\Http\Controllers\Api\CommonController;
use App\Http\Controllers\Api\LeadController;
use App\Http\Controllers\Api\LeadDataController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;


// Route::get('/dashboard', function () {
//     return view('dashboard');
// })->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::controller(CommonController::class)->group(function () {
  Route::get('privacy/policy/data','privacyPolicy');
  Route::get('terms/condition/data','termCondition');
});

 Route::controller(LeadDataController::class)->group(function () {
    Route::get('asset/data/get','AssetData');
    Route::get('condition/data/get','ConditionData');
    Route::get('TitleData/get','TitleData');
 });

 Route::controller(LeadController::class)->group(function () {
    Route::post('create/lead','store');
 });
