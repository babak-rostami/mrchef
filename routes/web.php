<?php

use App\Http\Controllers\IndexController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::get('/', [IndexController::class, 'home'])->name('home');

Route::get('register', [UserController::class, 'registerShow'])->name('register.show');
Route::post('register', [UserController::class, 'register'])->name('register');

Route::post('logout', [UserController::class, 'logout'])->name('logout');