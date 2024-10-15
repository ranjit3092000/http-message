<?php

// use App\Http\Controllers\Admin\Auth\AdminAuthController;
use App\Http\Controllers\Admin\Auth\AdminAuthController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Route::get('/register', [AdminAuthController::class, 'register'])->name('register');
Route::post('/store', [AdminAuthController::class, 'store'])->name('store');
Route::get('/login', [AdminAuthController::class, 'login'])->name('login');
Route::post('/loginredirect', [AdminAuthController::class, 'loginredirect'])->name('loginredirect');

// Auth::routes();

Route::middleware(['auth'])->group(function () {

    Route::get('/', function () {
        return view('welcome');
    })->name('welcome'); 

    // Route::get('/', [AdminAuthController::class, 'dashboard'])->name('dashboard');

});
