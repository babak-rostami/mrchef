<?php

use App\Http\Controllers\Auth\ForgotPasswordController;
use App\Http\Controllers\Frontend\IndexController;
use App\Http\Controllers\Frontend\SitemapController;
use App\Http\Controllers\Frontend\UserController;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\BFCkeditorController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\ContactMessageController;
use App\Http\Controllers\Admin\IngredientController;
use App\Http\Controllers\Admin\IngredientUnitController;
use App\Http\Controllers\Admin\RecipeController;
use App\Http\Controllers\Admin\RecipeIngredientController;
use App\Http\Controllers\Admin\UnitController;
use App\Http\Controllers\Auth\ResetPasswordController;
use App\Http\Controllers\Frontend\AboutController;
use App\Http\Controllers\Frontend\CommentController;
use App\Http\Controllers\Frontend\CommentReactionController;
use App\Http\Controllers\Frontend\ContactController;
use App\Http\Controllers\Frontend\RecipeController as FrontendRecipeController;
use App\Http\Controllers\Frontend\SearchController;
use Illuminate\Support\Facades\Route;


//------------------------------------------------------------------------------------
//------------------------------all user routes---------------------------------------
//------------------------------------------------------------------------------------

Route::get('/', [IndexController::class, 'home'])->name('home');
Route::post('/search', [SearchController::class, 'index']);

// ------------------------------recipe routes--------------------------------------
Route::get('/recipes/{category:slug?}', [FrontendRecipeController::class, 'index'])->name('recipes.index');
Route::get('/recipe/{recipe:slug}', action: [FrontendRecipeController::class, 'show'])->name('recipes.show');

// ------------------------------comment routes--------------------------------------
Route::get('show-comment-replies/{comment}', [CommentController::class, 'showReplies']);
Route::post('comments/{comment}/reaction', [CommentReactionController::class, 'toggle']);
Route::get('load-more-comments', [CommentController::class, 'loadMore']);

Route::get('/about', [AboutController::class, 'index'])->name('about');
Route::get('/contact', [ContactController::class, 'show'])->name('contact.show');
Route::post('/contact', [ContactController::class, 'store'])
    ->name('contact.store')
    ->middleware('throttle:5,1');

//------------------------------------------------------------------------------------
//--------------------------------admin routes----------------------------------------
//------------------------------------------------------------------------------------
Route::middleware(['role:admin'])
    ->prefix('admin_page')
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

        Route::get('messages', [ContactMessageController::class, 'index'])->name('messages.index');
        Route::delete('messages/{message}', [ContactMessageController::class, 'destroy'])->name('messages.destroy');
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
    Route::get('login', [UserController::class, 'loginShow'])->name('login.show');

    Route::post('register', [UserController::class, 'register'])->name('register')->middleware('throttle:5,1');
    Route::post('login', [UserController::class, 'login'])->name('login')->middleware('throttle:10,1');
    Route::post('check-email-exist', [UserController::class, 'checkEmailExist'])->middleware('throttle:10,1');
    Route::post('/forgot-password', [ForgotPasswordController::class, 'sendResetLink'])->middleware('throttle:5,1');
    Route::post('/reset-password', [ResetPasswordController::class, 'reset'])->middleware('throttle:10,1');

    // ------------------------------password reset routes--------------------------------------
    Route::get('/reset-password/{token}', [ResetPasswordController::class, 'showForm'])
        ->name('password.reset');
});

Route::get('sitemap.xml', [SitemapController::class, 'index'])->name('sitemap.index');
Route::get('sitemap-pages.xml', [SitemapController::class, 'pages'])->name('sitemap.pages');
Route::get('sitemap-recipes-{chunk}.xml', [SitemapController::class, 'recipes'])
    ->name('sitemap.recipes')
    ->where('chunk', '[0-9]+');
