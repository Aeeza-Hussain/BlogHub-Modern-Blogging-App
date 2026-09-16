<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ArticleController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\AuthorController;
use App\Http\Controllers\PageController;
use App\Http\Controllers\SearchController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;

/*
|--------------------------------------------------------------------------
| BlogHub Web Routes (SRS v2.0)
|--------------------------------------------------------------------------
*/

// Auth Flow Routes (Public / Guest accessible)
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
Route::post('/register', [AuthController::class, 'register']);
Route::get('/forgot-password', [AuthController::class, 'showForgotPassword'])->name('forgot-password');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Protected Routes (Require Login / Registration before visiting website content)
Route::middleware('auth')->group(function () {
    // Home Page
    Route::get('/', [HomeController::class, 'index'])->name('home');
    Route::get('/home', [HomeController::class, 'index']);

    // Admin Dashboard Routes
    Route::prefix('dashboard')->group(function () {
        Route::get('/', [DashboardController::class, 'index'])->name('dashboard.index');
        Route::get('/articles', [DashboardController::class, 'articles'])->name('dashboard.articles');
        Route::delete('/articles/{id}', [DashboardController::class, 'deleteArticle'])->name('dashboard.articles.delete');
        Route::get('/charts', [DashboardController::class, 'charts'])->name('dashboard.charts');
        Route::get('/account', [DashboardController::class, 'account'])->name('dashboard.account');
        Route::get('/settings', [DashboardController::class, 'settings'])->name('dashboard.settings');
        Route::get('/notifications', [DashboardController::class, 'notifications'])->name('dashboard.notifications');
        Route::get('/help', [DashboardController::class, 'help'])->name('dashboard.help');
    });

    // Blog CRUD Routes
    Route::get('/blogs', [ArticleController::class, 'index'])->name('blogs.index');
    Route::get('/blogs/create', [ArticleController::class, 'create'])->name('blogs.create');
    Route::post('/blogs', [ArticleController::class, 'store'])->name('blogs.store');
    Route::get('/blogs/{slug}', [ArticleController::class, 'show'])->name('blogs.show');
    Route::post('/blogs/{id}/like', [ArticleController::class, 'like'])->name('blogs.like');
    Route::post('/blogs/{id}/comments', [ArticleController::class, 'storeComment'])->name('blogs.comments.store');

    // Categories
    Route::get('/categories', [CategoryController::class, 'index'])->name('categories.index');

    // Authors
    Route::get('/authors', [AuthorController::class, 'index'])->name('authors.index');
    Route::get('/authors/{slug}', [AuthorController::class, 'show'])->name('authors.show');

    // Search
    Route::get('/search', [SearchController::class, 'index'])->name('search');

    // Marketing & Legal Pages
    Route::get('/about', [PageController::class, 'about'])->name('about');
    Route::get('/contact', [PageController::class, 'contact'])->name('contact');
    Route::post('/contact', [PageController::class, 'storeContact'])->name('contact.store');
    Route::get('/privacy-policy', [PageController::class, 'privacy'])->name('privacy');
    Route::get('/terms-and-conditions', [PageController::class, 'terms'])->name('terms');
});

// Custom 404 Fallback Route
Route::fallback(function () {
    return response()->view('errors.404', [], 404);
});

