<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\OpdController;
use App\Http\Controllers\OpdpartSaveController;
use Illuminate\Contracts\Cache\Store;

Route::middleware(['set.active.nav'])->group(function () {

    // Routes handled by OpdController

    Route::controller(OpdController::class)->group(function () {

        Route::get('/', 'registeredlist')->name('home');

        Route::get('/doctpanel/opd_pages.indexopd', 'registeredlist')->name('index');

        Route::get('reception/reglist', 'registeredlist')->name('reception.reglist');

        Route::get('/doctpanel/opd_oldnew/{regno}', 'opdOldNewData')->name('opd.regno');
    });
});
Route::post('/save-parts-details', [OpdpartSaveController::class, 'store'])->name('save.parts.details');
Route::get('/opd/{id}/report', [OpdController::class, 'show']);
Route::get('/report/{regno}', [OpdController::class, 'report'])->name('report.show');

Route::get('/dummy', function () {
    return view('/doctpanel/spine_pages/dummy_spine');
});
