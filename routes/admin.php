<?php

use App\Livewire\AllTags;
use App\Livewire\PlanAdd;
use App\Livewire\PostAdd;
use App\Livewire\AllPosts;
use App\Livewire\PlanEdit;
use App\Livewire\PostEdit;
use App\Livewire\UserEdit;
use App\Livewire\AllAffiliates;
use App\Livewire\AllCategories;
use App\Livewire\UserPurchases;
use App\Livewire\AllWithdrawals;
use Illuminate\Support\Facades\Route;
use App\Livewire\AffiliateUserDetails;
use App\Http\Controllers\PlanController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\OptionController;
use App\Http\Controllers\AffiliateApplicationController;
use App\Livewire\PostDetails;

Route::group(['prefix' => 'admin', 'middleware' => ['auth', 'verified', 'role:admin']], function () {
    Route::get('/', [AdminController::class, 'dashboard'])->name('admin-home');

    Route::get('/affiliate/applications', [AffiliateApplicationController::class, 'index'])->name('all-applications');
    Route::get('/applications', [AffiliateApplicationController::class, 'applications'])->name('get-applications');
    Route::post('/application/{id}/approve', [AffiliateApplicationController::class, 'approve'])->name('approve-application');
    Route::post('/application/{id}/cancel', [AffiliateApplicationController::class, 'cancel'])->name('cancel-application');
    Route::post('/application/{id}/delete', [AffiliateApplicationController::class, 'delete'])->name('delete-application');

    Route::get('/plans', [PlanController::class, 'index'])->name('all-plans');
    Route::get('/plan/add', PlanAdd::class)->name('add-plan');
    Route::get('/plans/{plan:slug}', PlanEdit::class)->name('edit-plan');
    Route::delete('/plans/{plan:slug}', [PlanController::class, 'deletePlan'])->name('delete-plan');

    Route::get('/affiliates', AllAffiliates::class)->name('all-affiliates');
    Route::get('/affiliates/{userId}/manage', AffiliateUserDetails::class)->name('affiliate-manage');

    Route::get('/withdrawals', AllWithdrawals::class)->name('all-withdrawals');

    Route::get('/categories', AllCategories::class)->name('all-categories');
    Route::get('/tags', AllTags::class)->name('all-tags');

    Route::get('/blogs', AllPosts::class)->name('all-posts');
    Route::get('/blog/create', PostAdd::class)->name('add-post');
    Route::get('/blog/{post:slug}/update', PostEdit::class)->name('edit-post');
    Route::get('/blog/{post:slug}', PostDetails::class)->name('view-post');

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
