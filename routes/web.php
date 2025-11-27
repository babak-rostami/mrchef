<?php

use App\Http\Controllers\BFCkeditorController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\IndexController;
use App\Http\Controllers\IngredientController;
use App\Http\Controllers\IngredientUnitController;
use App\Http\Controllers\RecipeController;
use App\Http\Controllers\RecipeIngredientController;
use App\Http\Controllers\UnitController;
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
    Route::post('bf-ckeditor-upload/{page}', [BFCkeditorController::class, 'upload']);
});

Route::middleware('admin')->group(function () {
    Route::resource('category', CategoryController::class);
    Route::resource('recipes', RecipeController::class);
    Route::resource('ingredient', IngredientController::class);
    Route::resource('unit', UnitController::class);

    Route::prefix('ingredient/{ingredient}/units')
        ->name('ingredient.units.')
        ->group(function () {
            Route::get('/', [IngredientUnitController::class, 'index'])->name('index');
            Route::post('/', [IngredientUnitController::class, 'store'])->name('store');
            Route::put('/{unit}', [IngredientUnitController::class, 'update'])->name('update');
            Route::delete('/{unit}', [IngredientUnitController::class, 'destroy'])->name('destroy');
        });

    Route::prefix('recipe/{recipe}/ingredients')
        ->name('recipe.ingredients.')
        ->group(function () {
            Route::get('/', [RecipeIngredientController::class, 'index'])->name('index');
            Route::post('/', [RecipeIngredientController::class, 'store'])->name('store');
            Route::put('/{ingredient}', [RecipeIngredientController::class, 'update'])->name('update');
            Route::delete('/{ingredient}', [RecipeIngredientController::class, 'destroy'])->name('destroy');
        });

    Route::prefix('select')->group(function () {
        Route::get('/ingredient/{ingredient}/units', [IngredientController::class, 'units']);
    });
});
