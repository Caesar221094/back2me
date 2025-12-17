<?php

use App\Http\Controllers\ReportController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\SettingsController;
use App\Http\Controllers\Admin\ReportExportController;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth'])->group(function () {
    Route::get('/back2me', function(){ return redirect()->route('back2me.reports.index'); });

    // reports
    Route::get('/back2me/reports', [ReportController::class,'index'])->name('back2me.reports.index');
    Route::get('/back2me/reports/create', [ReportController::class,'create'])->name('back2me.reports.create');
    Route::post('/back2me/reports', [ReportController::class,'store'])->name('back2me.reports.store');
    Route::get('/back2me/reports/{report}', [ReportController::class,'show'])->name('back2me.reports.show');
    Route::get('/back2me/reports/{report}/edit', [ReportController::class,'edit'])->name('back2me.reports.edit');
    Route::put('/back2me/reports/{report}', [ReportController::class,'update'])->name('back2me.reports.update');

    // claim a report (user)
    Route::post('/back2me/reports/{report}/claim', [ReportController::class,'claim'])->name('back2me.reports.claim');

    // confirm receipt (user)
    Route::post('/back2me/reports/{report}/confirm', [ReportController::class,'confirmReceipt'])->name('back2me.reports.confirm');

    // verify & change status (petugas)
    Route::post('/back2me/reports/{report}/verify', [ReportController::class,'verify'])->middleware('role:petugas|superadmin')->name('back2me.reports.verify');

    // admin management (superadmin only)
    Route::prefix('back2me/admin')->middleware('role:superadmin')->group(function(){
        // user management
        Route::resource('users', UserController::class)->names('back2me.admin.users');
        Route::post('users/{user}/reset-password', [UserController::class,'resetPassword'])->name('back2me.admin.users.reset_password');

        // category management
        Route::resource('categories', CategoryController::class)->names('back2me.admin.categories');

        // system settings
        Route::get('settings', [SettingsController::class,'index'])->name('back2me.admin.settings.index');
        Route::post('settings', [SettingsController::class,'update'])->name('back2me.admin.settings.update');

        // report export
        Route::get('reports/export', [ReportExportController::class,'index'])->name('back2me.admin.reports.export');
        Route::post('reports/export/monthly', [ReportExportController::class,'exportMonthly'])->name('back2me.admin.reports.export.monthly');
        Route::post('reports/export/yearly', [ReportExportController::class,'exportYearly'])->name('back2me.admin.reports.export.yearly');
    });
});
