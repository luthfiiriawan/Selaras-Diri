<?php

use App\Http\Controllers\Admin\AuthController;
use App\Http\Controllers\Admin\CmsController;
use App\Http\Controllers\HomeController;
use Illuminate\Support\Facades\Route;

Route::get('/', HomeController::class)->name('home');
Route::get('/tentang', [HomeController::class, 'about'])->name('about');
Route::get('/layanan', [HomeController::class, 'services'])->name('services');
Route::get('/psikolog', [HomeController::class, 'psychologistsPage'])->name('psychologists');
Route::get('/psikolog/{psychologist}/{slug?}', [HomeController::class, 'psychologistDetail'])->name('psychologists.show');
Route::get('/event', [HomeController::class, 'events'])->name('events');

Route::prefix('admin')->name('admin.')->group(function () {
    Route::get('/login', [AuthController::class, 'show'])->name('login');
    Route::post('/login', [AuthController::class, 'authenticate'])->name('authenticate');
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

    Route::middleware('cms.auth')->group(function () {
        Route::get('/', [CmsController::class, 'index'])->name('dashboard');
        Route::put('/settings', [CmsController::class, 'updateSettings'])->name('settings.update');

        Route::post('/psychologists', [CmsController::class, 'storePsychologist'])->name('psychologists.store');
        Route::put('/psychologists/{psychologist}', [CmsController::class, 'updatePsychologist'])->name('psychologists.update');
        Route::delete('/psychologists/{psychologist}', [CmsController::class, 'destroyPsychologist'])->name('psychologists.destroy');

        Route::post('/packages', [CmsController::class, 'storePackage'])->name('packages.store');
        Route::put('/packages/{package}', [CmsController::class, 'updatePackage'])->name('packages.update');
        Route::delete('/packages/{package}', [CmsController::class, 'destroyPackage'])->name('packages.destroy');

        Route::post('/events', [CmsController::class, 'storeEvent'])->name('events.store');
        Route::put('/events/{event}', [CmsController::class, 'updateEvent'])->name('events.update');
        Route::delete('/events/{event}', [CmsController::class, 'destroyEvent'])->name('events.destroy');
    });
});
