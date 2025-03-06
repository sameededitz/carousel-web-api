<?php

use App\Livewire\PlanAdd;
use App\Livewire\PlanEdit;
use App\Livewire\UserPurchases;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PlanController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\OptionController;
use App\Http\Controllers\AffiliateApplicationController;
use App\Livewire\UserEdit;

Route::group(['prefix' => 'admin', 'middleware' => ['auth', 'verified', 'verifyRole:admin']], function () {
    Route::get('/', [AdminController::class, 'dashboard'])->name('admin-home');

    Route::get('/affiliate/applications', [AffiliateApplicationController::class, 'index'])->name('all-applications');

    Route::get('/applications', [AffiliateApplicationController::class, 'applications'])->name('get-applications');

    Route::post('/application/{id}/approve', [AffiliateApplicationController::class, 'approve'])->name('approve-application');

    Route::post('/application/{id}/cancel', [AffiliateApplicationController::class, 'cancel'])->name('cancel-application');

    Route::post('/application/{id}/delete', [AffiliateApplicationController::class, 'delete'])->name('delete-application');

    Route::get('/plans', [PlanController::class, 'index'])->name('all-plans');
    Route::get('/plan/add', PlanAdd::class)->name('add-plan');
    Route::get('/plans/{plan:slug}', PlanEdit::class)->name('edit-plan');
    Route::delete('/plans/{plan:slug}', [PlanController::class, 'destroy'])->name('delete-plan');

    Route::get('/users', [AdminController::class, 'AllUsers'])->name('all-users');
    Route::get('/users/{userId}/manage', UserPurchases::class)->name('user-purchases');
    Route::get('/user/{user}/edit', UserEdit::class)->name('edit-user');
    Route::delete('/user/{user}/delete', [AdminController::class, 'deleteUser'])->name('delete-user');

    Route::get('/options', [OptionController::class, 'Options'])->name('all-options');
    Route::post('/options/save', [OptionController::class, 'saveOptions'])->name('save-options');

    Route::get('/adminUsers', [AdminController::class, 'allAdmins'])->name('all-admins');

    Route::get('/signup', [AdminController::class, 'addAdmin'])->name('add-admin');

    Route::get('/edit-admin/{user}', [AdminController::class, 'editAdmin'])->name('edit-admin');

    Route::delete('/delete-admin/{user}', [AdminController::class, 'deleteAdmin'])->name('delete-admin');
});
