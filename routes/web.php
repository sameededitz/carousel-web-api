<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\VerifyController;
use App\Livewire\ResetPassword;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    if (Auth::check()) {
        return redirect()->route('admin-home');
    }
    return redirect()->route('login');
})->name('home');

Route::get('email/verify/view/{id}/{hash}', [VerifyController::class, 'viewEmail'])->name('email.verification.view');
Route::get('password/reset/view/{email}/{token}', [VerifyController::class, 'viewInBrowser'])->name('password.reset.view');

Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'LoginForm'])->name('login');

    Route::post('/login', [AuthController::class, 'login'])->name('login.post')->middleware('throttle:6,1');

    Route::get('/reset-password/{token}', ResetPassword::class)->name('password.reset');
});

Route::middleware('auth')->group(function () {
    Route::get('/email/verify/{id}/{hash}', [VerifyController::class, 'verify'])->middleware(['signed', 'throttle:6,1'])->withoutMiddleware(['auth'])->name('verification.verify');

    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
});

require __DIR__ . '/admin.php';

Route::get('/api/docs', function () {
    return view('docs.api-docs');
})->name('api-docs');

Route::get('/optimize', function () {
    Artisan::call('optimize');
    return 'Optimized';
});
Route::get('/optimize-clear', function () {
    Artisan::call('optimize:clear');
    return 'Optimized';
});
Route::get('/migrate-fresh', function () {
    Artisan::call('migrate:fresh --seed');
    return 'Migrated and Seeded';
});
Route::get('/migrate', function () {
    Artisan::call('migrate');
    return 'Migrated and Seeded';
});
Route::get('/storage-link', function () {
    Artisan::call('storage:link');
    return 'Storage Linked';
});