<?php

use App\Http\Controllers\AffiliateApplicationController;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\PurchaseController;
use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\Api\VerifyController;
use App\Http\Controllers\CarouselController;
use App\Http\Controllers\ImageController;
use App\Http\Controllers\OptionController;
use App\Http\Controllers\PlanController;
use Illuminate\Support\Facades\Route;

Route::middleware('guest')->group(function () {
    Route::post('/login', [AuthController::class, 'login'])->name('api.login');

    Route::post('/reset-password', [VerifyController::class, 'sendResetLink'])->name('api.reset.password');

    Route::post('/auth/google', [AuthController::class, 'handleGoogleCallback'])->name('api.auth.google');

    Route::post('/affiliate/apply', [AffiliateApplicationController::class, 'apply'])->name('api.affiliate.apply');
});

Route::middleware('auth:sanctum')->group(function () {
    Route::get('/user', [UserController::class, 'user'])->name('api.user');

    Route::put('/user', [UserController::class, 'update'])->name('api.user.update');

    Route::put('/user/ai-creations',[UserController::class, 'incrementAiCreations'])->name('api.user.ai-creations');

    Route::post('/logout', [AuthController::class, 'logout'])->name('api.logout');

    Route::get('/purchase/active', [PurchaseController::class, 'active'])->name('api.plan.active');

    Route::get('/purchase/history', [PurchaseController::class, 'history'])->name('api.plan.history');

    Route::post('/purchase/add', [PurchaseController::class, 'addPurchase'])->name('api.add.purchase');

    Route::get('/carousels', [CarouselController::class, 'carousels'])->name('api.carousel');

    Route::get('/carousel/{carousel}', [CarouselController::class, 'view'])->name('api.carousel.show');

    Route::post('/carousel', [CarouselController::class, 'store'])->name('api.carousel.store');

    Route::delete('/carousel/delete', [CarouselController::class, 'destroy'])->name('api.carousel.destroy');
});
Route::post('/image/upload', [ImageController::class, 'store'])->name('api.image.upload');

Route::post('/email/resend-verification', [VerifyController::class, 'resendVerify'])->name('api.verify.resend');

Route::get('/options', [OptionController::class, 'getOptions'])->name('api.options');

Route::get('/plans', [PlanController::class, 'plans'])->name('api.plans');