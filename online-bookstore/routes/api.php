<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\BookController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\QuizController;
use App\Http\Controllers\WishlistController;
use App\Http\Controllers\AdminController;

// Auth
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout']);
Route::post('/password/reset', [AuthController::class, 'sendResetLinkEmail']);

// Books
Route::get('/books', [BookController::class, 'index']);
Route::get('/books/{id}', [BookController::class, 'show']);
Route::middleware(['auth', 'admin'])->group(function () {
    Route::post('/books', [BookController::class, 'store']);
    Route::put('/books/{id}', [BookController::class, 'update']);
    Route::delete('/books/{id}', [BookController::class, 'destroy']);
});

// Orders
Route::middleware('auth')->group(function () {
    Route::get('/orders', [OrderController::class, 'index']);
    Route::get('/orders/{id}', [OrderController::class, 'show']);
    Route::post('/orders', [OrderController::class, 'store']);
});

// Quizzes
Route::middleware('auth')->group(function () {
    Route::get('/quizzes/{book_id}', [QuizController::class, 'index']);
    Route::post('/quizzes/{quiz_id}/submit', [QuizController::class, 'submit']);
    Route::get('/user/quiz-results', [QuizController::class, 'userResults']);
});
