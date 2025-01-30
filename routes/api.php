<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\PurchaseController;
use App\Http\Controllers\Api\VerifyController;
use App\Http\Controllers\BrandController;
use App\Http\Controllers\CarouselController;
use App\Http\Controllers\ColorController;
use App\Http\Controllers\ContentTextController;
use App\Http\Controllers\OptionController;
use Illuminate\Support\Facades\Route;

Route::middleware('guest')->group(function () {
    Route::post('/login', [AuthController::class, 'login'])->name('api.login');

    Route::post('/signup', [AuthController::class, 'signup'])->name('api.signup');

    Route::post('/reset-password', [VerifyController::class, 'sendResetLink'])->name('api.reset.password');

    Route::post('/auth/google', [AuthController::class, 'handleGoogleCallback'])->name('api.auth.google');
});

Route::middleware('auth:sanctum')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout'])->name('api.logout');

    Route::post('/purchase', [PurchaseController::class, 'addPurchase'])->name('api.add.purchase');

    Route::post('/purchase/status', [PurchaseController::class, 'Status'])->name('api.purchase');

    Route::get('/carousels', [CarouselController::class, 'carousels'])->name('api.carousel');

    Route::get('/carousel/{carousel}', [CarouselController::class, 'view'])->name('api.carousel.show');

    Route::post('/carousel', [CarouselController::class, 'store'])->name('api.carousel.store');

    Route::delete('/carousel/delete', [CarouselController::class, 'destroy'])->name('api.carousel.destroy');

    Route::get('/carousel/{carousel}/content-text', [ContentTextController::class, 'view'])->name('api.content.text');

    Route::post('/carousel/content-text', [ContentTextController::class, 'store'])->name('api.content.text.store');

    Route::delete('/carousel/content-text', [ContentTextController::class, 'destroy'])->name('api.content.text.destroy');

    Route::get('/carousel/{carousel}/color', [ColorController::class, 'view'])->name('api.color.show');

    Route::post('/carousel/color', [ColorController::class, 'store'])->name('api.color.store');

    Route::delete('/carousel/color', [ColorController::class, 'destroy'])->name('api.color.destroy');

    Route::get('/carousel/{carousel}/brand', [BrandController::class, 'view'])->name('api.content.text.show');

    Route::post('/carousel/brand', [BrandController::class, 'store'])->name('api.content.text.store');

    Route::delete('/carousel/brand', [BrandController::class, 'destroy'])->name('api.content.text.destroy');
});

Route::post('/email/resend-verification', [VerifyController::class, 'resendVerify'])->name('api.verify.resend');

Route::get('/options', [OptionController::class, 'getOptions'])->name('api.options');
