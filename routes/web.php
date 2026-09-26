<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ArticleController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\AuthorController;
use App\Http\Controllers\PageController;
use App\Http\Controllers\SearchController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\Backend\DashboardController;

/*
|--------------------------------------------------------------------------
| BlogHub Web Routes (SRS v2.0)
|--------------------------------------------------------------------------
*/

// Public Routes (Accessible to everyone)
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/home', [HomeController::class, 'index']);

// Article Creation & Actions (Must be defined BEFORE /blogs/{slug} wildcard)
Route::middleware(['auth', 'can.publish'])->group(function () {
    Route::get('/blogs/create', [ArticleController::class, 'create'])->name('blogs.create');
    Route::post('/blogs', [ArticleController::class, 'store'])->name('blogs.store');
    Route::post('/blogs/{id}/like', [ArticleController::class, 'like'])->name('blogs.like');
    Route::post('/blogs/{id}/comments', [ArticleController::class, 'storeComment'])->name('blogs.comments.store');
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
});

Route::get('/blogs', [ArticleController::class, 'index'])->name('blogs.index');
Route::get('/blogs/{slug}', [ArticleController::class, 'show'])->name('blogs.show');

Route::get('/categories', [CategoryController::class, 'index'])->name('categories.index');

Route::get('/authors', [AuthorController::class, 'index'])->name('authors.index');
Route::get('/authors/{slug}', [AuthorController::class, 'show'])->name('authors.show');

Route::get('/search', [SearchController::class, 'index'])->name('search');

Route::get('/about', [PageController::class, 'about'])->name('about');
Route::get('/contact', [PageController::class, 'contact'])->name('contact');
Route::post('/contact', [PageController::class, 'storeContact'])->name('contact.store');
Route::get('/privacy-policy', [PageController::class, 'privacy'])->name('privacy');
Route::get('/terms-and-conditions', [PageController::class, 'terms'])->name('terms');

// Auth Flow Routes (Guest accessible)
Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);
    Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
    Route::post('/register', [AuthController::class, 'register']);
    Route::get('/forgot-password', [AuthController::class, 'showForgotPassword'])->name('forgot-password');
});

// Protected Routes (Require Login)
Route::middleware('auth')->group(function () {
    // Admin Dashboard Routes
        Route::prefix('dashboard')->group(function () {
            Route::get('/', [DashboardController::class, 'index'])->name('dashboard.index');
            Route::get('/articles', [DashboardController::class, 'articles'])->name('dashboard.articles');
            Route::get('/charts', [DashboardController::class, 'charts'])->name('dashboard.charts');
            Route::get('/account', [DashboardController::class, 'account'])->name('dashboard.account');
            Route::get('/settings', [DashboardController::class, 'settings'])->name('dashboard.settings');
            Route::get('/notifications', [DashboardController::class, 'notifications'])->name('dashboard.notifications');
            Route::get('/help', [DashboardController::class, 'help'])->name('dashboard.help');
            Route::get('/website', [DashboardController::class, 'website'])->name('dashboard.website');
            Route::get('/website/{section}', [DashboardController::class, 'websiteSection'])->name('dashboard.website.section');

            // Author: manage only their own articles
            Route::delete('/articles/{id}', [DashboardController::class, 'deleteArticle'])
                ->middleware('can.publish')
                ->name('dashboard.articles.delete');

            // Admin-only website configuration
            Route::middleware('admin')->group(function () {
                Route::post('/website/hero', [DashboardController::class, 'updateHeroSettings'])->name('dashboard.website.hero.update');
                Route::post('/website/trending/{id}/toggle', [DashboardController::class, 'toggleTrending'])->name('dashboard.website.trending.toggle');
                Route::post('/website/categories', [DashboardController::class, 'storeCategory'])->name('dashboard.website.categories.store');
                Route::put('/website/categories/{id}', [DashboardController::class, 'updateCategory'])->name('dashboard.website.categories.update');
                Route::delete('/website/categories/{id}', [DashboardController::class, 'deleteCategory'])->name('dashboard.website.categories.delete');
                Route::post('/website/authors', [DashboardController::class, 'storeAuthor'])->name('dashboard.website.authors.store');
                Route::put('/website/authors/{id}', [DashboardController::class, 'updateAuthor'])->name('dashboard.website.authors.update');
                Route::delete('/website/authors/{id}', [DashboardController::class, 'deleteAuthor'])->name('dashboard.website.authors.delete');
            });
        });
});

// Custom 404 Fallback Route
Route::fallback(function () {
    return response()->view('errors.404', [], 404);
});


