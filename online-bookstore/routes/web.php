<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Web\AuthWebController;
use App\Http\Controllers\Web\BookWebController;
use App\Http\Controllers\Web\DashboardWebController;
use App\Http\Controllers\Web\ProfileWebController;

// Auth
Route::get('/login', [AuthWebController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthWebController::class, 'login']);
Route::get('/register', [AuthWebController::class, 'showRegister']);
Route::post('/register', [AuthWebController::class, 'register']);
Route::post('/logout', [AuthWebController::class, 'logout']);

// Books
Route::get('/', [BookWebController::class, 'index']);
Route::get('/books', [BookWebController::class, 'index']);
Route::get('/books/{id}', [BookWebController::class, 'show']);

// Dashboard
Route::middleware('auth')->group(function () {
    Route::get('/dashboard', [DashboardWebController::class, 'index']);
    Route::get('/profile', [ProfileWebController::class, 'show']);
    Route::post('/profile/update', [ProfileWebController::class, 'update']);
    // Wishlist
    Route::get('/user/wishlist', [\App\Http\Controllers\Web\WishlistWebController::class, 'index']);
    // Orders
    Route::get('/orders', [\App\Http\Controllers\Web\OrderWebController::class, 'index']);
    // Quiz
    Route::get('/quizzes/{book_id}', [\App\Http\Controllers\Web\QuizWebController::class, 'index']);
    Route::get('/user/quiz-results', [\App\Http\Controllers\Web\QuizWebController::class, 'results']);
    // (Admin pages can be added here)
});
