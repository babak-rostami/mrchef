<?php

use App\Http\Controllers\CategoryController;
use App\Http\Controllers\IndexController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::get('/', [IndexController::class, 'home'])->name('home');
Route::get('register', [UserController::class, 'registerShow'])->name('register.show');
Route::post('register', [UserController::class, 'register'])->name('register');
Route::get('login', [UserController::class, 'loginShow'])->name('login.show');
Route::post('login', [UserController::class, 'login'])->name('login');
Route::post('logout', [UserController::class, 'logout'])->name('logout');
Route::get('dashboard', [UserController::class, 'dashboard'])->name('dashboard')->middleware('is_admin');

Route::get('category', [CategoryController::class, 'index'])->name('category.index');
Route::post('category', [CategoryController::class, 'store'])->name('category.store');
