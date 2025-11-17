<?php

use App\Http\Controllers\CategoryController;
use App\Http\Controllers\IndexController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::get('/', [IndexController::class, 'home'])->name('home');

Route::middleware('guest')->group(function () {
    Route::get('register', [UserController::class, 'registerShow'])->name('register.show');
    Route::post('register', [UserController::class, 'register'])->name('register');
    Route::get('login', [UserController::class, 'loginShow'])->name('login.show');
    Route::post('login', [UserController::class, 'login'])->name('login');
});

Route::middleware('auth')->group(function () {
    Route::get('dashboard', [UserController::class, 'dashboard'])->name('dashboard');
    Route::post('logout', [UserController::class, 'logout'])->name('logout');
});

Route::middleware('admin')->group(function () {
    Route::resource('category', CategoryController::class);
});

Route::get('test', function () {
    return view('test');
});
