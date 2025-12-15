<?php

use App\Http\Controllers\Frontend\IndexController;
use App\Http\Controllers\Frontend\UserController;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\BFCkeditorController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\IngredientController;
use App\Http\Controllers\Admin\IngredientUnitController;
use App\Http\Controllers\Admin\RecipeController;
use App\Http\Controllers\Admin\RecipeIngredientController;
use App\Http\Controllers\Admin\UnitController;
use App\Http\Controllers\Frontend\CommentController;
use App\Http\Controllers\Frontend\RecipeController as FrontendRecipeController;
use Illuminate\Support\Facades\Route;

Route::get('/', [IndexController::class, 'home'])->name('home');


//------------------------------------------------------------------------------------
//------------------------------all user routes---------------------------------------
//------------------------------------------------------------------------------------

// ------------------------------recipe routes--------------------------------------
Route::get('/recipes/{category:slug?}', [FrontendRecipeController::class, 'index'])->name('recipes.index');
Route::get('/recipe/{recipe:slug}', action: [FrontendRecipeController::class, 'show'])->name('recipes.show');

// ------------------------------recipe routes--------------------------------------
Route::get('show-comment-replies/{comment}', [CommentController::class, 'showReplies'])->name('show.comment.replies');

//------------------------------------------------------------------------------------
//--------------------------------admin routes----------------------------------------
//------------------------------------------------------------------------------------
Route::middleware(['role:admin'])
    ->prefix('admin')
    ->name('admin.')
    ->group(function () {
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

        Route::get('dashboard', [AdminController::class, 'dashboard'])->name('dashboard');
        Route::post('bf-ckeditor-upload/{page}', [BFCkeditorController::class, 'upload']);
    });

//------------------------------------------------------------------------------------
//---------------------------------user routes----------------------------------------
//------------------------------------------------------------------------------------
Route::middleware('auth')->group(function () {
    Route::post('logout', [UserController::class, 'logout'])->name('logout');

    // ------------------------------comment routes--------------------------------------
    Route::post('comment-store', [CommentController::class, 'store'])->name('comment.store');
});

//------------------------------------------------------------------------------------
//----------------auth user can not access this routes--------------------------------
//------------------------------------------------------------------------------------
Route::middleware('guest')->group(function () {
    Route::get('register', [UserController::class, 'registerShow'])->name('register.show');
    Route::post('register', [UserController::class, 'register'])->name('register');
    Route::get('login', [UserController::class, 'loginShow'])->name('login.show');
    Route::post('login', [UserController::class, 'login'])->name('login');
});
