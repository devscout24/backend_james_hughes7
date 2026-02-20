<?php

use App\Http\Controllers\Backend\AssetController;
use App\Http\Controllers\Backend\ConditionController;
use App\Http\Controllers\Backend\TitleSituationController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;



// Route::get('/dashboard', function () {
//     return view('dashboard');
// })->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

   Route::controller(AssetController::class)->group(function () {
       Route::get('asset/type/index', 'index')->name('assettype.index');
       Route::get('asset/get/data','GetData')->name('asset.getData');
        Route::post('asset/store','store')->name('asset.store');
        Route::post('/admin/asset/update/{id}','update')->name('update');
        Route::post('/admin/asset/delete/{id}','destroy')->name('destroy');
   });

   Route::controller(ConditionController::class)->group(function () {
    Route::get('condition/index','index')->name('condition.index');

    Route::get('/get/data', 'getData')->name('getData.Condition');
    Route::post('/condition/store', 'store')->name('condition.store');
    Route::post('/admin/condition/update/{id}', 'update');
    Route::post('/admin/condition/delete/{id}', 'destroy');
   });

   Route::controller(TitleSituationController::class)->group(function () {
     Route::get('title/index','index')->name('title.index');

    Route::get('titleSituation/get-data', 'getData')->name('titleSituation.getData');
    Route::post('titleSituation/store', 'store')->name('titleSituation.store');
    Route::post('/admin/title-situation/update/{id}', 'update');
    Route::post('/admin/title-situation/delete/{id}', 'destroy');
   });

});

require __DIR__ . '/auth.php';
require __DIR__ . '/backend.php';
