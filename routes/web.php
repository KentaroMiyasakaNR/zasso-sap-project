<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ReportController;
use Illuminate\Support\Facades\Route;

Route::prefix('zasso-sap')->group(function () {
    Route::get('/', function () {
        return view('welcome');
    });

    Route::get('/dashboard', function () {
        return view('dashboard');
    })->middleware(['auth', 'verified'])->name('dashboard');

    Route::middleware('auth')->group(function () {
        Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
        Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
        Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    });

    Route::middleware(['auth', 'web'])->group(function () {
        Route::resource('report', ReportController::class);
        Route::post('/report/analyze', [ReportController::class, 'analyze'])->name('report.analyze');
        Route::post('/reports', [ReportController::class, 'store'])->name('reports.store');
        // ... 他のレポート関連のルート ...
    });
});

require __DIR__.'/auth.php';