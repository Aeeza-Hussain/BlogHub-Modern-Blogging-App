<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ArticleController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\AuthorController;
use App\Http\Controllers\PageController;
use App\Http\Controllers\SearchController;
use App\Http\Controllers\AuthController;

/*
|--------------------------------------------------------------------------
| BlogHub Web Routes (SRS v2.0)
|--------------------------------------------------------------------------
*/

// Home Page
Route::get('/', [HomeController::class, 'index'])->name('home');

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

// Auth Flow Views
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
Route::post('/register', [AuthController::class, 'register']);
Route::get('/forgot-password', [AuthController::class, 'showForgotPassword'])->name('forgot-password');

// Custom 404 Fallback Test Route
Route::fallback(function () {
    return response()->view('errors.404', [], 404);
});
