<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\BannerController;
use App\Http\Controllers\CategoryController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\PackageController;
use App\Http\Controllers\PartnerController;
use App\Http\Controllers\SquareFeedController;
use App\Http\Controllers\TransactionController;
use App\Http\Controllers\UserController;
use App\Http\Middleware\Auth;

Route::get('/', function () {
    return redirect('/dashboard/partner');
})->name('slash.home')->middleware('auth.jwt');

Route::middleware(['auth.jwt'])->prefix('dashboard')->group(function () {
    Route::view('/review', 'dashboard.review.index')->name('dashboard.review.index');
    
    // profile
    Route::post('/me', [AdminController::class, 'update'])->name('dashboard.banner.update');
    
        // sqarefeed
        Route::get('/squarefeed', [SquareFeedController::class, 'index'])->name('dashboard.squarefeed.index');
        Route::post('/squarefeed/create', [SquareFeedController::class, 'store'])->name('dashboard.squarefeed.store');
        Route::post('/squarefeed', [SquareFeedController::class, 'destroy'])->name('dashboard.squarefeed.destroy');
        Route::post('/squarefeed/{id}', [SquareFeedController::class, 'update'])->name('dashboard.banner.update');
        
        // banner
        Route::get('/banner', [BannerController::class, 'index'])->name('dashboard.banner.index');
        Route::post('/banner/create', [BannerController::class, 'store'])->name('dashboard.banner.store');
        Route::post('/banner', [BannerController::class, 'destroy'])->name('dashboard.banner.destroy');
        Route::post('/banner/{id}', [BannerController::class, 'update'])->name('dashboard.banner.update');
        
        // category
        Route::get('/category', [CategoryController::class, 'index'])->name('dashboard.category.index');
        Route::post('/category', [CategoryController::class, 'store'])->name('dashboard.category.create');
        Route::post('/category/{id}', [CategoryController::class, 'update'])->name('dashboard.category.update');
        Route::delete('/category', [CategoryController::class, 'destroy'])->name('dashboard.category.destroy');

        // partner 
        Route::get('/partner', [PartnerController::class, 'index'])->name('dashboard.partner.index');
        Route::get('/partner/{id}', [PartnerController::class, 'show'])->name('dashboard.partner.show');
        Route::post('/partner/{id}', [PartnerController::class, 'update'])->name('dashboard.partner.update');
        Route::get('/partner/{id}/confirmation/{account_status}', [PartnerController::class, 'confirmation'])->name('dashboard.partner.confirmation');
        Route::post('/partner', [PartnerController::class, 'destroy'])->name('dashboard.partner.destroy');
        
        // transaction
        Route::get('/transaction', [TransactionController::class, 'index'])->name('dashboard.transaction.index');
        Route::get('/transaction/{id}/confirmation/{status}', [TransactionController::class, 'confirmation'])->name('dashboard.partner.confirmation');
        
        // customer
        Route::get('/customer', [UserController::class, 'index'])->name('dashboard.customer.index');
        Route::post('/customer', [UserController::class, 'destroy'])->name('dashboard.customer.destroy');
        Route::post('/customer/{id}', [UserController::class, 'update'])->name('dashboard.customer.update');
        
        //package
        Route::get('/package', [PackageController::class, 'index'])->name('dashboard.package.index');
        Route::post('/package', [PackageController::class, 'store'])->name('dashboard.package.create');
        Route::post('/package/{id}', [PackageController::class, 'update'])->name('dashboard.package.update');
        Route::delete('/package', [PackageController::class, 'destroy'])->name('dashboard.package.destroy');
        Route::middleware(['defaultVariable'])->group(function () {
    });
});

Route::get('/logout', [AuthController::class, 'logout'])->middleware('auth.jwt');
Route::get('/login', [DashboardController::class, 'login'])->name('dashboardlogin');
Route::post('/login', [AuthController::class, 'login']);
Route::get('/register', [DashboardController::class, 'register'])->name('dashboardregister');
Route::post('/register', [AuthController::class, 'register']);
