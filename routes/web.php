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
    Route::get('/blogs/{id}/edit', [ArticleController::class, 'edit'])->name('blogs.edit');
    Route::put('/blogs/{id}', [ArticleController::class, 'update'])->name('blogs.update');
});

// Authenticated User Actions (Commenting & Liking for registered users)
Route::middleware('auth')->group(function () {
    Route::post('/blogs/{id}/comments', [ArticleController::class, 'storeComment'])->name('blogs.comments.store');
    Route::post('/blogs/{id}/like', [ArticleController::class, 'like'])->name('blogs.like');
});

// Logout only requires auth, NOT can.publish
Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth')->name('logout');

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
Route::post('/newsletter/subscribe', [PageController::class, 'subscribeNewsletter'])->name('newsletter.subscribe');

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
            Route::get('/notifications', [DashboardController::class, 'notifications'])->name('dashboard.notifications');
            Route::get('/help', [DashboardController::class, 'help'])->name('dashboard.help');
            Route::get('/website', [DashboardController::class, 'website'])->name('dashboard.website');
            Route::get('/website/{section}', [DashboardController::class, 'websiteSection'])->name('dashboard.website.section');

            // Author: manage only their own articles
            Route::delete('/articles/{id}', [DashboardController::class, 'deleteArticle'])
                ->middleware('can.publish')
                ->name('dashboard.articles.delete');
            Route::post('/articles/{id}/submit-review', [DashboardController::class, 'submitArticleForReview'])
                ->middleware('can.publish')
                ->name('dashboard.articles.submit-review');

            // Profile, Password & Notifications Updates (Admin & Author)
            Route::post('/account/profile', [DashboardController::class, 'updateProfile'])->name('dashboard.account.profile');
            Route::post('/account/password', [DashboardController::class, 'updatePassword'])->name('dashboard.account.password');
            Route::post('/account/notifications', [DashboardController::class, 'updateNotificationPreferences'])->name('dashboard.account.notifications');

            // Admin-only management
            Route::middleware('admin')->group(function () {
                // Platform Settings
                Route::get('/settings', [DashboardController::class, 'settings'])->name('dashboard.settings');
                Route::post('/settings', [DashboardController::class, 'updateSettings'])->name('dashboard.settings.update');

                // Website Layout & Portions
                Route::post('/website/hero', [DashboardController::class, 'updateHeroSettings'])->name('dashboard.website.hero.update');
                Route::post('/website/trending/{id}/toggle', [DashboardController::class, 'toggleTrending'])->name('dashboard.website.trending.toggle');
                Route::post('/website/categories', [DashboardController::class, 'storeCategory'])->name('dashboard.website.categories.store');
                Route::put('/website/categories/{id}', [DashboardController::class, 'updateCategory'])->name('dashboard.website.categories.update');
                Route::delete('/website/categories/{id}', [DashboardController::class, 'deleteCategory'])->name('dashboard.website.categories.delete');
                Route::post('/website/authors', [DashboardController::class, 'storeAuthor'])->name('dashboard.website.authors.store');
                Route::put('/website/authors/{id}', [DashboardController::class, 'updateAuthor'])->name('dashboard.website.authors.update');
                Route::delete('/website/authors/{id}', [DashboardController::class, 'deleteAuthor'])->name('dashboard.website.authors.delete');

                // User Management
                Route::get('/users', [DashboardController::class, 'users'])->name('dashboard.users');
                Route::put('/users/{id}', [DashboardController::class, 'updateUser'])->name('dashboard.users.update');
                Route::put('/users/{id}/type', [DashboardController::class, 'updateUserType'])->name('dashboard.users.type');
                Route::post('/users/{id}/toggle-status', [DashboardController::class, 'toggleUserStatus'])->name('dashboard.users.toggle-status');
                Route::delete('/users/{id}', [DashboardController::class, 'deleteUser'])->name('dashboard.users.delete');

                // Author Management
                Route::get('/authors', [DashboardController::class, 'authors'])->name('dashboard.authors');
                Route::post('/authors', [DashboardController::class, 'storeAuthor'])->name('dashboard.authors.store');
                Route::put('/authors/{id}', [DashboardController::class, 'updateAuthor'])->name('dashboard.authors.update');
                Route::post('/authors/{id}/toggle-status', [DashboardController::class, 'toggleAuthorStatus'])->name('dashboard.authors.toggle-status');
                Route::delete('/authors/{id}', [DashboardController::class, 'deleteAuthor'])->name('dashboard.authors.delete');

                // Category Management
                Route::get('/categories', [DashboardController::class, 'categories'])->name('dashboard.categories');
                Route::post('/categories', [DashboardController::class, 'storeCategory'])->name('dashboard.categories.store');
                Route::put('/categories/{id}', [DashboardController::class, 'updateCategory'])->name('dashboard.categories.update');
                Route::delete('/categories/{id}', [DashboardController::class, 'deleteCategory'])->name('dashboard.categories.delete');

                // Admin: All Articles & Moderation
                Route::get('/all-articles', [DashboardController::class, 'allArticles'])->name('dashboard.all-articles');
                Route::post('/articles/{id}/approve', [DashboardController::class, 'approveArticle'])->name('dashboard.articles.approve');
                Route::post('/articles/{id}/reject', [DashboardController::class, 'rejectArticle'])->name('dashboard.articles.reject');
                Route::post('/articles/{id}/unpublish', [DashboardController::class, 'unpublishArticle'])->name('dashboard.articles.unpublish');
                Route::delete('/all-articles/{id}', [DashboardController::class, 'adminDeleteArticle'])->name('dashboard.all-articles.delete');
            });

            // Comments Management (Authors manage comments on their own articles; Admins manage all)
            Route::middleware('can.publish')->group(function () {
                Route::get('/comments', [DashboardController::class, 'comments'])->name('dashboard.comments');
                Route::post('/comments/{id}/approve', [DashboardController::class, 'approveComment'])->name('dashboard.comments.approve');
                Route::post('/comments/{id}/hide', [DashboardController::class, 'hideComment'])->name('dashboard.comments.hide');
                Route::delete('/comments/{id}', [DashboardController::class, 'deleteComment'])->name('dashboard.comments.delete');
            });
        });
});

// Custom 404 Fallback Route
Route::fallback(function () {
    return response()->view('errors.404', [], 404);
});


