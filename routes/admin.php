<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\AffiliateApplicationController;
use App\Http\Controllers\OptionController;
use App\Http\Controllers\PlanController;
use App\Http\Controllers\ServerController;
use App\Http\Controllers\SubServerController;
use App\Livewire\SubServerAdd;
use App\Livewire\SubServerEdit;
use Illuminate\Support\Facades\Route;

Route::group(['prefix' => 'admin', 'middleware' => ['auth', 'verified', 'verifyRole:admin']], function () {
    Route::get('/', [AdminController::class, 'dashboard'])->name('admin-home');

    Route::get('/affiliate/applications', [AffiliateApplicationController::class, 'index'])->name('all-applications');

    Route::get('/applications', [AffiliateApplicationController::class, 'applications'])->name('get-applications');

    Route::post('/application/{id}/approve', [AffiliateApplicationController::class, 'approve'])->name('approve-application');

    Route::post('/application/{id}/cancel', [AffiliateApplicationController::class, 'cancel'])->name('cancel-application');

    Route::post('/application/{id}/delete', [AffiliateApplicationController::class, 'delete'])->name('delete-application');

    Route::get('/servers', [ServerController::class, 'Index'])->name('all-servers');

    Route::get('/add-server', [ServerController::class, 'AddServer'])->name('add-server');

    Route::get('/server/{server}/edit', [ServerController::class, 'EditServer'])->name('edit-server');

    Route::delete('/delete-server/{server}', [ServerController::class, 'DeleteServer'])->name('delete-server');

    Route::get('/{server}/sub-servers', [SubServerController::class, 'Index'])->name('all-sub-servers');

    Route::get('/{server}/sub-server/add', SubServerAdd::class)->name('add-sub-server');

    Route::get('/{server}/sub-servers/{subServer}/edit', SubServerEdit::class)->name('edit-sub-server');

    Route::delete('/{server}/sub-servers/{subServer}', [SubServerController::class, 'Delete'])->name('delete-sub-server');

    Route::get('/plans', [PlanController::class, 'Index'])->name('all-plans');
    Route::get('/add-plan', [PlanController::class, 'AddPlan'])->name('add-plan');
    Route::get('/plans/{plan:slug}', [PlanController::class, 'EditPlan'])->name('edit-plan');
    Route::delete('/plans/{plan:slug}', [PlanController::class, 'deletePlan'])->name('delete-plan');

    Route::get('/customers', [AdminController::class, 'AllUsers'])->name('all-users');
    Route::delete('/delete-user/{user}', [AdminController::class, 'deleteUser'])->name('delete-user');

    Route::get('/options', [OptionController::class, 'Options'])->name('all-options');
    Route::post('/options/save', [OptionController::class, 'saveOptions'])->name('save-options');

    Route::get('/adminUsers', [AdminController::class, 'allAdmins'])->name('all-admins');

    Route::get('/signup', [AdminController::class, 'addAdmin'])->name('add-admin');

    Route::get('/edit-admin/{user}', [AdminController::class, 'editAdmin'])->name('edit-admin');

    Route::delete('/delete-admin/{user}', [AdminController::class, 'deleteAdmin'])->name('delete-admin');
});
