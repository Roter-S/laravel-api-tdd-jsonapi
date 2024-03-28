<?php

use App\Http\Controllers\Api\InstrumentController;
use Illuminate\Support\Facades\Route;

Route::prefix('instruments')->name('api.v1.instruments.')->group(function () {
    Route::get('', [InstrumentController::class, 'index'])->name('index');
    Route::get('{instrument}', [InstrumentController::class, 'show'])->name('show');
    Route::post('', [InstrumentController::class, 'store'])->name('store');
});
