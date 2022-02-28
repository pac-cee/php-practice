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
